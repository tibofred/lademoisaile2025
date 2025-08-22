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
        $choices = array(
                    '2017-2018' => '2017-2018',
                    '2018-2019' => '2018-2019',
                    '2019-2020' => '2019-2020',
                    '2020-2021' => '2020-2021',
                    '2021-2022' => '2021-2022',
                    '2022-2023' => '2022-2023',
                    '2023-2024' => '2023-2024',
                    '2024-2025' => '2024-2025',
                );
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('annee', ChoiceType::class, array(
                'choices'  => $choices,
            ))
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
