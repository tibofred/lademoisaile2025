<?php

namespace SiteBundle\Form\Type;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Viweb\BaseBundle\Form\Type\MediaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RessourceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('slug')
            ->add('image', MediaType::class, array(
                'required' => false
            ))
            ->add('mini_description', CKEditorType::class, array(
                'label' => 'Mini description',
                'required' => false,
                'config' => array(
                    'uiColor' => '#ffffff',
                )
            ))
            ->add('contenu', CKEditorType::class, array(
                'config' => array(
                    'uiColor' => '#ffffff',
                )
            ))
            ->add('parent', EntityType::class, array(
                'class' => 'SiteBundle\Entity\Ressource',
                'choice_label' => 'titre',
                'multiple' => false,
                'required' => false
            ))
            ->add('ordre', IntegerType::class, array(
                'attr' => array('min' => 0)
            ))
            
            ->add('save',      SubmitType::class, array(
                    'attr' => array('class' => 'btn gredient-btn disabled'),
                ));

        //SEO
        parent::buildForm($builder, $options);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SiteBundle\Entity\Ressource'
        ));
    }

    public function getBlockPrefix()
    {
        return 'site_bundle_ressource_type';
    }
}
