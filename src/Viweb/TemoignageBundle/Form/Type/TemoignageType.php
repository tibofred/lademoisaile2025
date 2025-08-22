<?php

namespace Viweb\TemoignageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class TemoignageType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contenu', CKEditorType::class, array(
                'config' => array(
                    'uiColor' => '#ffffff',
                )
            ))
            ->add('lien')
            ->add('personne')
            ->add('ordre')
            ->add('signature')
            ->add('save',      SubmitType::class, array(
                    'attr' => array('class' => 'btn gredient-btn disabled'),
                ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Viweb\TemoignageBundle\Entity\Temoignage'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'viweb_temoignagebundle_temoignage';
    }


}
