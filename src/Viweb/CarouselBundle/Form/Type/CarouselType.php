<?php

namespace Viweb\CarouselBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Viweb\BaseBundle\Form\Type\MediaType;

class CarouselType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('images', CollectionType::class, array(
                'required' => false,
                'by_reference' => false,
                'entry_type' => MediaType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'entry_options' => array('label' => false),
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Viweb\CarouselBundle\Entity\Carousel'
        ));
    }

    public function getBlockPrefix()
    {
        return 'viweb_carousel_bundle_carousel_type';
    }
}
