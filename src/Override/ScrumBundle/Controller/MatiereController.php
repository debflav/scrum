<?php

namespace Override\ScrumBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Override\ScrumBundle\Entity\Matiere;
use Override\ScrumBundle\Form\MatiereType;

/**
 * Matiere controller.
 *
 * @Route("/matiere")
 */
class MatiereController extends Controller
{

    /**
     * Lists all Matiere entities.
     *
     * @Route("/", name="matiere")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('OverrideScrumBundle:Matiere')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Matiere entity.
     *
     * @Route("/", name="matiere_create")
     * @Method("POST")
     * @Template("OverrideScrumBundle:Matiere:new.html.twig")
     */
    public function createAction(Request $request)
    {
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
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Matiere entity.
    *
    * @param Matiere $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Matiere $entity)
    {
        $form = $this->createForm(new MatiereType(), $entity, array(
            'action' => $this->generateUrl('matiere_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Matiere entity.
     *
     * @Route("/new", name="matiere_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Matiere();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Matiere entity.
     *
     * @Route("/{id}", name="matiere_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OverrideScrumBundle:Matiere')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Matiere entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Matiere entity.
     *
     * @Route("/{id}/edit", name="matiere_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OverrideScrumBundle:Matiere')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Matiere entity.');
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
    * Creates a form to edit a Matiere entity.
    *
    * @param Matiere $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Matiere $entity)
    {
        $form = $this->createForm(new MatiereType(), $entity, array(
            'action' => $this->generateUrl('matiere_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Matiere entity.
     *
     * @Route("/{id}", name="matiere_update")
     * @Method("PUT")
     * @Template("OverrideScrumBundle:Matiere:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
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
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Matiere entity.
     *
     * @Route("/{id}", name="matiere_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
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
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('matiere_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
