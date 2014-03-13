<?php

namespace Override\ScrumBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Override\ScrumBundle\Entity\Thematique;
use Override\ScrumBundle\Form\ThematiqueType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Thematique controller.
 *
 * @Route("/thematique")
 */
class ThematiqueController extends Controller
{

    /**
     * Lists all Thematique entities.
     *
     * @Secure({"ROLE_ADMIN", "ROLE_SECRETARY"})
     * @Route("/", name="thematique")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('OverrideScrumBundle:Thematique')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Thematique entity.
     *
     * @Secure({"ROLE_ADMIN", "ROLE_SECRETARY"})
     * @Route("/", name="thematique_create")
     * @Method("POST")
     * @Template("OverrideScrumBundle:Thematique:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Thematique();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('thematique_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Thematique entity.
    *
    * @param Thematique $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Thematique $entity)
    {
        $form = $this->createForm(new ThematiqueType(), $entity, array(
            'action' => $this->generateUrl('thematique_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Thematique entity.
     *
     * @Secure({"ROLE_ADMIN", "ROLE_SECRETARY"})
     * @Route("/new", name="thematique_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Thematique();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Thematique entity.
     *
     * @Secure({"ROLE_ADMIN", "ROLE_SECRETARY"})
     * @Route("/{id}", name="thematique_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OverrideScrumBundle:Thematique')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Thematique entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Thematique entity.
     *
     * @Secure({"ROLE_ADMIN", "ROLE_SECRETARY"})
     * @Route("/{id}/edit", name="thematique_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OverrideScrumBundle:Thematique')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Thematique entity.');
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
    * Creates a form to edit a Thematique entity.
    *
    * @param Thematique $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Thematique $entity)
    {
        $form = $this->createForm(new ThematiqueType(), $entity, array(
            'action' => $this->generateUrl('thematique_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Thematique entity.
     *
     * @Secure({"ROLE_ADMIN", "ROLE_SECRETARY"})
     * @Route("/{id}", name="thematique_update")
     * @Method("PUT")
     * @Template("OverrideScrumBundle:Thematique:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OverrideScrumBundle:Thematique')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Thematique entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('thematique_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Thematique entity.
     *
     * @Secure({"ROLE_ADMIN", "ROLE_SECRETARY"})
     * @Route("/{id}", name="thematique_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('OverrideScrumBundle:Thematique')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Thematique entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('thematique'));
    }

    /**
     * Creates a form to delete a Thematique entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('thematique_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
