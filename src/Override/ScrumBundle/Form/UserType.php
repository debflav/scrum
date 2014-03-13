<?php

namespace Override\ScrumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('roles', null, array('label' => 'Update role'));
              ->add('roles', 'choice', array(
                'choices'   => array(
                    'ROLE_ADMIN'     => 'Administrateur',
                    'ROLE_SECRETARY' => 'Secretaire',
                    'ROLE_PROFESSOR' => 'Enseignant',
                    'ROLE_STUDENT'   => 'Etudiant',
                ),
                //'multiple'  => true,
                "mapped" => false)
                )
            ->add('dernierDiplome', 'text', array('label' => 'Saisir le dernier diplôme', 'required' => false, 'mapped' => false))
            ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Override\FosUserBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'override_scrumbundle_user';
    }
}
