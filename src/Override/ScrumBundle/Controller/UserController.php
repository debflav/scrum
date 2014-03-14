<?php

namespace Override\ScrumBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Override\FosUserBundle\Entity\User;
use Override\ScrumBundle\Form\UserType as UserType;
use Override\ScrumBundle\Entity\SecretaireFormation;
use Override\ScrumBundle\Entity\Professeur;
use Override\ScrumBundle\Entity\Etudiant;

/**
 * User controller.
 *
 * @Route("/user")
 */
class UserController extends Controller
{

    /**
     * Lists all User entities.
     *
     * @Secure({"ROLE_ADMIN", "ROLE_SECRETARY"})
     * @Route("/", name="user")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('OverrideFosUserBundle:User')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/{id}/edit", name="user_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OverrideFosUserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a User entity.
    *
    * @param User $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(User $entity)
    {
        $form = $this->createForm(new UserType(), $entity, array(
            'action' => $this->generateUrl('user_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing User entity.
     *
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/{id}", name="user_update")
     * @Method("PUT")
     * @Template("OverrideScrumBundle:User:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        /** Retrieve the user **/
        $user = $em->getRepository('OverrideFosUserBundle:User')->find($id);
        if (!$user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        /** Set edit and delete form **/
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($user);

        $editForm->handleRequest($request);

        /** Form is valid we can insert the user **/
        if ($editForm->isValid()) {

            /** Remove user from all table where he can exist**/
            $issetSecretaire = $em->getRepository('OverrideScrumBundle:SecretaireFormation')->findOneBy(array('user' => $user->getId()));
            if($issetSecretaire) {
                $em->remove($issetSecretaire);
            }

             $issetProfesseur = $em->getRepository('OverrideScrumBundle:Professeur')->findOneBy(array('user' => $user->getId()));
            if($issetProfesseur) {
                $em->remove($issetProfesseur);
            }

            $issetEtudiant = $em->getRepository('OverrideScrumBundle:Etudiant')->findOneBy(array('user' => $user->getId()));
            if($issetEtudiant) {
                $em->remove($issetEtudiant);
            }
            // Flushes remove from enity
            $em->flush();

            // Set the user role and persist
            $user->setRoles(array($editForm->get('roles')->getData()));
            $em->persist($user);

            /** Insert in database (depends of user role) **/
            switch ($editForm->get('roles')->getData()) {
                case 'ROLE_ADMIN':
                    $user->setRoles(array('ROLE_ADMIN'));
                    break;
                case 'ROLE_SECRETARY':
                    $secretaire = new SecretaireFormation();
                    $secretaire->setUser($user);
                    $em->persist($secretaire);
                    break;
                case 'ROLE_PROFESSOR':
                    $professeur = new Professeur();
                    $professeur->setUser($user);
                    $em->persist($professeur);
                    break;
                case 'ROLE_STUDENT':
                    // If the diplome is null redirect the user
                    if($editForm->get('dernierDiplome')->getData() == NULL) {
                        $this->get('session')->getFlashBag()->add(
                            "danger",
                            "Le diplôme doit être rempli pour l'étudiant."
                        );
                        return $this->redirect($this->generateUrl('user_edit', array('id' => $user->getId())));
                    }
                    $etudiant = new Etudiant();
                    $etudiant->setUser($user);
                    $etudiant->setDernierDiplome($editForm->get('dernierDiplome')->getData());
                    $em->persist($etudiant);
                    break;
                default:
                    return $this->redirect($this->generateUrl('user_edit', array('id' => $user->getId())));
                    break;
            }
            // Flush in the database
            $em->flush();

            // Redirect to the user list
            return $this->redirect($this->generateUrl('user'));
        }

        // Redirect to the form when form not valid
        return array(
            'entity'      => $user,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a User entity.
     *
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/{id}", name="user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('OverrideFosUserBundle:User')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('user'));
    }

    /**
     * Creates a form to delete a User entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

}