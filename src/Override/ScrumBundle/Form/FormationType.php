<?php

namespace Override\ScrumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FormationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('descriptif')
            ->add('critere', 'textarea', array('label' => "Critères d'acceptation"))
            ->add('secretaireFormation', 'entity', array(
                    'query_builder' => function($entity) { return $entity->createQueryBuilder('p')->orderBy('p.id', 'ASC'); },
                    'property' => 'user',
                    'class' => 'OverrideScrumBundle:SecretaireFormation',
                )
            );

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Override\ScrumBundle\Entity\Formation'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'override_scrumbundle_formation';
    }
}
