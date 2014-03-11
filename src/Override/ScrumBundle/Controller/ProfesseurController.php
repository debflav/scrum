<?php

namespace Override\ScrumBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Override\ScrumBundle\Entity\Professeur;
use Override\ScrumBundle\Form\ProfesseurType;

/**
 * Professeur controller.
 *
 * @Route("/professeur")
 */
class ProfesseurController extends Controller
{

    /**
     * Lists all Professeur entities.
     *
     * @Route("/", name="professeur")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('OverrideScrumBundle:Professeur')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Professeur entity.
     *
     * @Route("/", name="professeur_create")
     * @Method("POST")
     * @Template("OverrideScrumBundle:Professeur:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Professeur();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('professeur_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Professeur entity.
    *
    * @param Professeur $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Professeur $entity)
    {
        $form = $this->createForm(new ProfesseurType(), $entity, array(
            'action' => $this->generateUrl('professeur_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Professeur entity.
     *
     * @Route("/new", name="professeur_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Professeur();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Professeur entity.
     *
     * @Route("/{id}", name="professeur_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OverrideScrumBundle:Professeur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Professeur entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Professeur entity.
     *
     * @Route("/{id}/edit", name="professeur_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OverrideScrumBundle:Professeur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Professeur entity.');
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
    * Creates a form to edit a Professeur entity.
    *
    * @param Professeur $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Professeur $entity)
    {
        $form = $this->createForm(new ProfesseurType(), $entity, array(
            'action' => $this->generateUrl('professeur_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Professeur entity.
     *
     * @Route("/{id}", name="professeur_update")
     * @Method("PUT")
     * @Template("OverrideScrumBundle:Professeur:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OverrideScrumBundle:Professeur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Professeur entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('professeur_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Professeur entity.
     *
     * @Route("/{id}", name="professeur_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('OverrideScrumBundle:Professeur')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Professeur entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('professeur'));
    }

    /**
     * Creates a form to delete a Professeur entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('professeur_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
