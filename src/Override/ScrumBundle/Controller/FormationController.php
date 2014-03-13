<?php

namespace Override\ScrumBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Override\ScrumBundle\Entity\Formation;
use Override\ScrumBundle\Form\FormationType;

/**
 * Formation controller.
 *
 * @Route("/formation")
 */
class FormationController extends Controller {

    /**
     * Lists all Formation entities.
     *
     * @Secure(roles={"ROLE_ADMIN", "ROLE_SECRETAIRE"})
     * @Route("/", name="formation")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $usr = $em->getRepository('OverrideScrumBundle:SecretaireFormation')->findBy(array('id' => $this->getUser()->getId()));

        if ($usr) {
            $entities = $em->getRepository('OverrideScrumBundle:Formation')->findAll();
        } else {
            $entities = $em->getRepository('OverrideScrumBundle:Formation')->findBySecretaireFormation($this->getUser());
        }

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Formation entity.
     *
     * @Secure(roles={"ROLE_ADMIN", "ROLE_SECRETAIRE"})
     * @Route("/", name="formation_create")
     * @Method("POST")
     * @Template("OverrideScrumBundle:Formation:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new Formation();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        // POST value
        $data = $this->get('request')->request->get('override_scrumbundle_formation');
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('OverrideScrumBundle:SecretaireFormation')->find($data['secretaireFormation']);

        if (!$entities) {
            throw new \Exception('Unable to find the secretary');
        }

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('formation'));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Formation entity.
     *
     * @param Formation $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Formation $entity) {
        $form = $this->createForm(new FormationType(), $entity, array(
            'action' => $this->generateUrl('formation_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Ajouter', 'attr' => array('class' => 'btn btn-success')));

        return $form;
    }

    /**
     * Displays a form to create a new Formation entity.
     *
     * @Secure(roles={"ROLE_ADMIN", "ROLE_SECRETAIRE"})
     * @Route("/new", name="formation_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new Formation();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Formation entity.
     *
     * @Secure(roles={"ROLE_ADMIN", "ROLE_SECRETAIRE"})
     * @Route("/{id}", name="formation_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OverrideScrumBundle:Formation')->find($id);

        $cursus = $em->getRepository('OverrideScrumBundle:Cursus')->findByFormation($entity);
        $matieres = $cursus[0]->getMatiere();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Formation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'matieres' => $matieres,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Formation entity.
     *
     * @Secure(roles={"ROLE_ADMIN", "ROLE_SECRETAIRE"})
     * @Route("/{id}/edit", name="formation_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OverrideScrumBundle:Formation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Formation entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Formation entity.
     *
     * @param Formation $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Formation $entity) {
        $form = $this->createForm(new FormationType(), $entity, array(
            'action' => $this->generateUrl('formation_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Formation entity.
     *
     * @Secure(roles={"ROLE_ADMIN", "ROLE_SECRETAIRE"})
     * @Route("/{id}", name="formation_update")
     * @Method("PUT")
     * @Template("OverrideScrumBundle:Formation:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OverrideScrumBundle:Formation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Formation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('formation_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Formation entity.
     *
     * @Secure(roles={"ROLE_ADMIN", "ROLE_SECRETAIRE"})
     * @Route("/{id}", name="formation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('OverrideScrumBundle:Formation')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Formation entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('formation'));
    }

    /**
     * Creates a form to delete a Formation entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('formation_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
