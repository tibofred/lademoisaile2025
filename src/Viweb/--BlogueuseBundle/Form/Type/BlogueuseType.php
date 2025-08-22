<?php

namespace Viweb\BlogueuseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Viweb\EcoleBundle\Repository\EcoleRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class BlogueuseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('photo', PhotoType::class, array(
                'required' => false
            ))
            
            ->add('datePlanification', DateTimeType::class, array(

            'widget' => 'single_text',

            'format' => 'yyyy-MM-dd HH:mm',

            'required' => true,

            ))
            ->add('description', CKEditorType::class, array(
                'label' => 'Description',
                'required' => false,
                'config' => array(
                    'uiColor' => '#ffffff',
                )
            ))
            ->add('ecole', EntityType::class, array(
                
                'class' => 'ViwebEcoleBundle:Ecole',
                'choice_label' => 'nom',
            ))
            
            ->add('save',      SubmitType::class, array(
                    'attr' => array('class' => 'btn gredient-btn disabled'),
                ));
        
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Viweb\BlogueuseBundle\Entity\Blogueuse'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'viweb_blogueusebundle_blogueuse';
    }


}
