<?php

namespace Override\FosUserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('username', null, array('label' => 'Pseudonyme', 'translation_domain' => 'FOSUserBundle'))
            ->add('nom', null, array('label' => 'Nom', 'translation_domain' => 'FOSUserBundle'))
            ->add('prenom', null, array('label' => 'Prénom', 'translation_domain' => 'FOSUserBundle'))
            ->add('email', 'email', array('label' => 'Adresse email', 'translation_domain' => 'FOSUserBundle'))
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'Mot de passe'),
                'second_options' => array('label' => 'Confirmation du mot de passe'),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
            ->add('dateNaissance', null, array('label' => 'Date de naissance'))
            ->add('telephone', null, array('label' => 'Numéro de téléphone'))
            ->add('adresse', null, array('label' => 'Adresse'))
        ;
    }

    public function getName()
    {
        return 'override_fosuser_registration';
    }

}