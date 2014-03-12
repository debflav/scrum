<?php

namespace Override\ScrumBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Override\ScrumBundle\Entity\Cursus;
use Override\ScrumBundle\Form\CursusType;

/**
 * Cursus controller.
 *
 * @Route("/cursus")
 */
class CursusController extends Controller
{

    /**
     * Lists all Cursus entities.
     * @Secure(roles={"ROLE_ADMIN", "ROLE_SECRETARY"})
     * @Route("/", name="cursus")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('OverrideScrumBundle:Cursus')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Cursus entity.
     *
     * @Route("/", name="cursus_create")
     * @Method("POST")
     * @Template("OverrideScrumBundle:Cursus:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Cursus();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('cursus_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Cursus entity.
    *
    * @param Cursus $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Cursus $entity)
    {
        $form = $this->createForm(new CursusType(), $entity, array(
            'action' => $this->generateUrl('cursus_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Ajouter', 'attr' => array('class' => 'btn btn-success')));

        return $form;
    }

    /**
     * Displays a form to create a new Cursus entity.
     *
     * @Route("/new", name="cursus_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Cursus();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Cursus entity.
     *
     * @Route("/{id}", name="cursus_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OverrideScrumBundle:Cursus')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cursus entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Cursus entity.
     *
     * @Route("/{id}/edit", name="cursus_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OverrideScrumBundle:Cursus')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cursus entity.');
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
    * Creates a form to edit a Cursus entity.
    *
    * @param Cursus $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Cursus $entity)
    {
        $form = $this->createForm(new CursusType(), $entity, array(
            'action' => $this->generateUrl('cursus_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Cursus entity.
     *
     * @Route("/{id}", name="cursus_update")
     * @Method("PUT")
     * @Template("OverrideScrumBundle:Cursus:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OverrideScrumBundle:Cursus')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cursus entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('cursus_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Cursus entity.
     *
     * @Route("/{id}", name="cursus_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('OverrideScrumBundle:Cursus')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Cursus entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cursus'));
    }

    /**
     * Creates a form to delete a Cursus entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cursus_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
