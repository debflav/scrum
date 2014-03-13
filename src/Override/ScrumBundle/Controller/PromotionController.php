<?php

namespace Override\ScrumBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Override\ScrumBundle\Entity\Promotion;
use Override\ScrumBundle\Entity\Etudiant;
use Override\ScrumBundle\Entity\User;
use Override\ScrumBundle\Form\PromotionType;

/**
 * Promotion controller.
 *
 * @Route("/promotion")
 */
class PromotionController extends Controller
{

    /**
     * Lists all Promotion entities.
     * @Route("/", name="promotion")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        // Récupération de l'utilisateur connecté
        $user = $this->getUser();
        $userRoles = $user->getRoles();

        // Préparation de la base
        $em = $this->getDoctrine()->getManager();
        
        // Si l'utilisateur est MANAGER
        if(in_array('ROLE_ADMIN', $userRoles)){

            // Récupérer toutes les promotion
            $entities = $em->getRepository('OverrideScrumBundle:Promotion')->findAll();

        }else{

            // Récupérer les promotion du scretaire
            $entities = $em->getRepository('OverrideScrumBundle:Promotion')->findBySecretaireFormation($user->getId());

        }

        return array(
            'entities' => $entities
        );

    }

    /**
     * Get all promo by Formation.
     *
     * @Route("/formation/{id}", name="promotion_get_by_formation")
     * @Method("GET")
     * @Template("OverrideScrumBundle:Promotion:index.html.twig")
     */
    public function GetByFormationAction(Request $request, $id){

        $em = $this->getDoctrine()->getManager();

        // Récupération de l'utilisateur connecté
        $user = $this->getUser();
        $userRoles = $user->getRoles();

        // Préparation de la base
        $em = $this->getDoctrine()->getManager();
        
        // Si l'utilisateur est MANAGER
        if(in_array('ROLE_ADMIN', $userRoles)){

            // Récupérer toutes les promotion
            $entities = $em->getRepository('OverrideScrumBundle:Promotion')->findByFormation($id);

        }else{

            // Récupérer les promotion du scretaire
            $entities = $em->getRepository('OverrideScrumBundle:Promotion')->findBySecretaireFormationByFormation($user->getId(), $id);

        }

        return array(
            'entities' => $entities,
        );

    }   


    /**
     * Creates a new Promotion entity.
     *
     * @Route("/", name="promotion_create")
     * @Method("POST")
     * @Template("OverrideScrumBundle:Promotion:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Promotion();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('promotion_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Promotion entity.
    *
    * @param Promotion $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Promotion $entity)
    {

        $em = $this->getDoctrine()->getManager();

        // Récupération de l'utilisateur connecté
        $user = $this->getUser();
        $userRoles = $user->getRoles();

        // Préparation de la base
        $em = $this->getDoctrine()->getManager();


        $form = $this->createForm(new PromotionType(), $entity, array(
            'action' => $this->generateUrl('promotion_create'),
            'method' => 'POST',
        ));

        // Si l'utilisateur est secretaire
        if(in_array('ROLE_SECRETARY', $userRoles)){
            $form->add('cursus', 'entity', array(
                        'query_builder' => function($entity) use ($user){
                            return $entity
                                    ->createQueryBuilder('p')
                                    ->innerJoin('p.formation', 'formation')
                                    ->innerJoin('formation.secretaireFormation', 'secretaireFormation')
                                    ->where('secretaireFormation = :userId')
                                    ->orderBy('p.id', 'ASC')
                                    ->setParameter('userId', $user->getId());
                        },
                        'property' => 'formation.nom',
                        'class' => 'OverrideScrumBundle:Cursus',
                    ));
        }else{

            $form->add('cursus', 'entity', array(
                    'query_builder' => function($entity) { return $entity->createQueryBuilder('p')->orderBy('p.id', 'ASC'); },
                    'property' => 'formation.nom',
                    'class' => 'OverrideScrumBundle:Cursus',
                )
            );
        }

        $form->add('submit', 'submit', array('label' => 'Ajouter', 'attr' => array('class' => 'btn btn-primary')));

        return $form;
    }

    /**
     * Displays a form to create a new Promotion entity.
     *
     * @Route("/new", name="promotion_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Promotion();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Promotion entity.
     *
     * @Route("/{id}", name="promotion_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OverrideScrumBundle:Promotion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Promotion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Manage promotion
    *
    * @Route("/manage/{id}", name="manage_promotion")
    * @Method("GET")
    * @Template("OverrideScrumBundle:Promotion:add-student.html.twig")
    */
    public function managePromotionAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OverrideScrumBundle:Promotion')->find($id);
        

        // Étudiant de la promotion
        $arrayEtudiant = array();
        $etudiants = $em->getRepository('OverrideScrumBundle:Etudiant')->findAll();
        if($entity->getEtudiants()){
            
            foreach ($entity->getEtudiants() as $etudiant) {
                $arrayEtudiant[$etudiant->getId()] = $etudiant->getUser()->getNom();
            }
        }

        // Étudiant faisant partie d'une promotion
        $arrayEtudiantPromo = array();
        $promotions = $em->getRepository('OverrideScrumBundle:Etudiant')->findAllInPromotion($id);

        if($promotions){
            foreach ($promotions as $promotion) {
                foreach ($promotion->getEtudiants() as $etudiant) {
                    $arrayEtudiantPromo[$etudiant->getId()] = $etudiant->getUser()->getNom();
                }
            }
        }

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Promotion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'etudiants'   => $etudiants,
            'arrayEtudiant' => $arrayEtudiant,
            'arrayEtudiantPromo' => $arrayEtudiantPromo,
            'delete_form' => $deleteForm->createView(),
        );

    }

    /**
    * Add student to a promotion
    *
    * @Route("/add_student/{id}/{userId}", name="add_student")
    * @Method("GET")
    * @Template()
    */
    public function addStudentAction($id, $userId)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OverrideScrumBundle:Promotion')->find($id);
        $etudiant = $em->getRepository('OverrideScrumBundle:Etudiant')->find($userId);

        $entity->addEtudiant($etudiant);

        $em->flush();
        
        $response = $this->redirect($this->generateUrl('manage_promotion', array('id' => $id)));

        return $response;

    }

    /**
    * Remove student to a promotion
    *
    * @Route("/remove_student/{id}/{userId}", name="remove_student")
    * @Method("GET")
    * @Template()
    */
    public function removeStudentAction($id, $userId)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OverrideScrumBundle:Promotion')->find($id);
        $etudiant = $em->getRepository('OverrideScrumBundle:Etudiant')->find($userId);

        $entity->removeEtudiant($etudiant);

        $em->flush();
        
        $response = $this->redirect($this->generateUrl('manage_promotion', array('id' => $id)));

        return $response;

    }

    /**
     * Displays a form to edit an existing Promotion entity.
     *
     * @Route("/{id}/edit", name="promotion_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OverrideScrumBundle:Promotion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Promotion entity.');
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
    * Creates a form to edit a Promotion entity.
    *
    * @param Promotion $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Promotion $entity)
    {
        $form = $this->createForm(new PromotionType(), $entity, array(
            'action' => $this->generateUrl('promotion_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Promotion entity.
     *
     * @Route("/{id}", name="promotion_update")
     * @Method("PUT")
     * @Template("OverrideScrumBundle:Promotion:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OverrideScrumBundle:Promotion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Promotion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('promotion_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }



    /**
     * Deletes a Promotion entity.
     *
     * @Secure(roles="ROLE_ADMIN")
     * @Route("/{id}", name="promotion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('OverrideScrumBundle:Promotion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Promotion entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('promotion'));
    }

    /**
     * Creates a form to delete a Promotion entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('promotion_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
