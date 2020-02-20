<?php

namespace DorraBundle\Form;

use AppBundle\Entity\Club;
use AppBundle\Entity\Jardin;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActiviteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('typeact')->add('detailles')->add('club', EntityType::class,[
            'class' => Club::class,
            'choice_label' => 'name',
            'expanded' => false,
            'multiple' => false
        ])->add('photo', FileType::class, array('label'=>'insert image','data_class' => null,'required' => false));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Activite'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_activite';
    }


}
