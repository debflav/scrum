<?php

namespace Override\ScrumBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Override\ScrumBundle\Entity\Matiere;
use Override\ScrumBundle\Form\MatiereType;

/**
 * Matiere controller.
 *
 * @Route("/matiere")
 */
class MatiereController extends Controller {

    /**
     * Lists all Matiere entities.
     *
     * @Secure({"ROLE_ADMIN", "ROLE_SECRETARY"})
     * @Route("/", name="matiere")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('OverrideScrumBundle:Matiere')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    
    /**
    * Manage matiere
    *
    * @Secure({"ROLE_ADMIN", "ROLE_SECRETARY"})
    * @Route("/manage/{id}", name="manage_matiere")
    * @Method("GET")
    * @Template("OverrideScrumBundle:Matiere:add-professeur.html.twig")
    */
    public function managePromotionAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OverrideScrumBundle:Matiere')->find($id);
        

        // Étudiant de la promotion
        $arrayProfesseur = array();
        $professeurs = $em->getRepository('OverrideScrumBundle:Professeur')->findAll();
        if($entity->getProfesseur()){
            foreach ($entity->getProfesseur() as $professeur) {
                $arrayProfesseur[$professeur->getId()] = $professeur->getUser()->getNom();
            }
        }

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Promotion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'professeurs'   => $professeurs,
            'arrayProfesseur' => $arrayProfesseur,
            'delete_form' => $deleteForm->createView(),
        );

    }

    /**
    * Add student to a promotion
    *
    * @Secure({"ROLE_ADMIN", "ROLE_SECRETARY"})
    * @Route("/add_professeur/{id}/{userId}", name="add_professeur")
    * @Method("GET")
    * @Template()
    */
    public function addProfesseurAction($id, $userId)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OverrideScrumBundle:Matiere')->find($id);
        $professeur = $em->getRepository('OverrideScrumBundle:Professeur')->find($userId);

        $entity->addProfesseur($professeur);

        $em->flush();
        $this->get('session')->getFlashBag()->add('success', $professeur->getUser()->getNom(). ' a bien été Ajouté à la matière');
        
        $response = $this->redirect($this->generateUrl('manage_matiere', array('id' => $id)));

        return $response;

    }

    /**
    * Remove student to a promotion
    *
    * @Secure({"ROLE_ADMIN", "ROLE_SECRETARY"})
    * @Route("/remove_professeur/{id}/{userId}", name="remove_professeur")
    * @Method("GET")
    * @Template()
    */
    public function removeProfesseurAction($id, $userId)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OverrideScrumBundle:Matiere')->find($id);
        $professeur = $em->getRepository('OverrideScrumBundle:professeur')->find($userId);

        $entity->removeprofesseur($professeur);

        $em->flush();
        $this->get('session')->getFlashBag()->add('danger', $professeur->getUser()->getNom(). ' a bien été supprimer de la promotion');
        
        $response = $this->redirect($this->generateUrl('manage_matiere', array('id' => $id)));

        return $response;

    }

    /**
     * Creates a new Matiere entity.
     *
     * @Secure({"ROLE_ADMIN", "ROLE_SECRETARY"})
     * @Route("/", name="matiere_create")
     * @Method("POST")
     * @Template("OverrideScrumBundle:Matiere:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new Matiere();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('matiere_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Matiere entity.
     *
     * @param Matiere $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Matiere $entity) {
        $form = $this->createForm(new MatiereType(), $entity, array(
            'attr' => array('class' => 'form-horizontal'),
            'action' => $this->generateUrl('matiere_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Ajouter', 'attr' => array('class' => 'btn btn-success')));

        return $form;
    }

    /**
     * Displays a form to create a new Matiere entity.
     *
     * @Secure({"ROLE_ADMIN", "ROLE_SECRETARY"})
     * @Route("/new", name="matiere_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new Matiere();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Matiere entity.
     *
     * @Secure({"ROLE_ADMIN", "ROLE_SECRETARY"})
     * @Route("/{id}", name="matiere_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OverrideScrumBundle:Matiere')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Matiere entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Matiere entity.
     *
     * @Secure({"ROLE_ADMIN", "ROLE_SECRETARY"})
     * @Route("/{id}/edit", name="matiere_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OverrideScrumBundle:Matiere')->find($id);
        $professeurs = $entity->getProfesseur();

        $allProfs = $em->getRepository('OverrideScrumBundle:Professeur')->findAll();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Matiere entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'professeurs' => $professeurs,
            'profs' => $allProfs,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Matiere entity.
     *
     * @param Matiere $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Matiere $entity) {
        $form = $this->createForm(new MatiereType(), $entity, array(
            'action' => $this->generateUrl('matiere_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre à jour', 'attr' => array('class' => 'btn btn-primary')));

        return $form;
    }

    /**
     * Edits an existing Matiere entity.
     *
     * @Secure({"ROLE_ADMIN", "ROLE_SECRETARY"})
     * @Route("/{id}", name="matiere_update")
     * @Method("PUT")
     * @Template("OverrideScrumBundle:Matiere:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OverrideScrumBundle:Matiere')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Matiere entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('matiere_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Matiere entity.
     *
     * @Secure({"ROLE_ADMIN", "ROLE_SECRETARY"})
     * @Route("/{id}", name="matiere_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('OverrideScrumBundle:Matiere')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Matiere entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('matiere'));
    }

    /**
     * Creates a form to delete a Matiere entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('matiere_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Supprimer', 'attr' => array('class' => 'btn btn-danger')))
                        ->getForm()
        ;
    }

    /**
     * Ajout d'un prof à une matière.
     *
     * @Secure({"ROLE_ADMIN", "ROLE_SECRETARY"})
     * @Route("/{matiereId}/{profId}", name="matiere_add_prof")
     * @Method("GET")
     * @Template("OverrideScrumBundle:Matiere:edit.html.twig")
     */
    public function addprofAction($matiereId, $profId) {
        $em = $this->getDoctrine()->getManager();
        $matiere = $em->getRepository('OverrideScrumBundle:Matiere')->find($matiereId);
        $prof = $em->getRepository('OverrideScrumBundle:Professeur')->find($profId);

        $matiere->addProfesseur($prof);

        $em->flush();

        return $this->redirect($this->generateUrl('matiere_edit', array('id' => $matiereId)));
    }

}
