<?php

namespace SamiBundle\Form;

use AppBundle\Entity\Jardin;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChauffeurType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('cin')->add('nom')->add('tel')->add('sexe',ChoiceType::class,[
            'choices'=>[
                'Homme'=>'homme',
                'Femme'=>'femme'
            ],])
            ->add('jardin',EntityType::class,[
            'class'=>Jardin::class,
            'choice_label'=>'name',
            'multiple'=>false
        ])->add('username')
        ->add('email')
        ->add('password');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Chauffeur'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_chauffeur';
    }


}
