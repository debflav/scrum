<?php

namespace Override\ScrumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MatiereType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('coefficient')
            ->add('description')
            ->add('thematique', 'entity', array(
                    'query_builder' => function($entity) { return $entity->createQueryBuilder('p')->orderBy('p.id', 'ASC'); },
                    'property' => 'nom',
                    'class' => 'OverrideScrumBundle:Thematique',
                ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Override\ScrumBundle\Entity\Matiere'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'override_scrumbundle_matiere';
    }
}
