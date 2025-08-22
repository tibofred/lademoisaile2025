<?php

namespace SiteBundle\Form\Type;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Viweb\BaseBundle\Form\Type\MediaType;

class BlocType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('image', MediaType::class, array(
                'required' => false
            ))
            ->add('contenu', CKEditorType::class, array(
                'empty_data' => '',
                'config' => array(
                    'uiColor' => '#ffffff',
                    'allowedContent' => true
                ),
            ))
            ->add('ordre', IntegerType::class, array(
                'attr' => array('min' => 0)
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SiteBundle\Entity\Bloc'
        ));
    }

    public function getBlockPrefix()
    {
        return 'site_bundle_bloc_type';
    }
}
