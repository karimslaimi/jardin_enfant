<?php

namespace FeridBundle\Form;

use AppBundle\Entity\Enfant;
use AppBundle\Entity\Jardin;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AbonnementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('date')->add('type')->add('etat')->add('montant')->add('jardin', EntityType::class,[
                'class' => Jardin::class,
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => false
            ])->add('enfant', EntityType::class,[
            'class' => Enfant::class,
            'choice_label' => 'nom',
            'expanded' => false,
            'multiple' => false
        ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Abonnement'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_abonnement';
    }


}
