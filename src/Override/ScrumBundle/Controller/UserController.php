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
     * @Secure(roles="ROLE_ADMIN, ROLE_SECRETARY")
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

        /** Retrieve the role in POST data **/
        $postParameters = $this->getRequest()->request->get('override_scrumbundle_user');
        $user->setRoles(array($postParameters['roles']));

        $editForm->handleRequest($request);

        /** Form is valid we can insert the user **/
        if ($editForm->isValid()) {
            // Persist the user
            $em->persist($user);

            $issetSecretaire = $em->getRepository('OverrideScrumBundle:SecretaireFormation')->find($user->getId());
            if($issetSecretaire) {
                $em->remove($issetSecretaire);
            }

             $issetProfesseur = $em->getRepository('OverrideScrumBundle:Professeur')->find($user->getId());
            if($issetProfesseur) {
                $em->remove($issetProfesseur);
            }

            $issetEtudiant = $em->getRepository('OverrideScrumBundle:Etudiant')->find($user->getId());
            if($issetEtudiant) {
                $em->remove($issetEtudiant);
            }

            /** Insert indatabase in tables depends of user **/
            switch ($postParameters['roles']) {
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
                    $etudiant = new Etudiant();
                    $etudiant->setUser($user);
                    $em->persist($etudiant);
                    break;
                default:
                    break;
            }
            $em->flush();

            return $this->redirect($this->generateUrl('user'));
        }

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