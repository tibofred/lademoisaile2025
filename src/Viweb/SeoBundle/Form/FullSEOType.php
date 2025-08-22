<?php

namespace Viweb\SeoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Viweb\BaseBundle\Form\Type\MediaType;

abstract class FullSEOType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('metaTitle')
            ->add('ogtitle')
            ->add('metaDescription', TextareaType::class)
            ->add('ogdescription', TextareaType::class)
            ->add('fbImg', MediaType::class, array(
                'label' => 'Image Facebook 1200×628',
                'required' => false
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Viweb\SeoBundle\Entity\FullSEO'
        ));
    }


}
