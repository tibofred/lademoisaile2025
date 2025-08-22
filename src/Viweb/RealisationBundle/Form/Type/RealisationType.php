<?php

namespace Viweb\RealisationBundle\Form\Type;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Viweb\BaseBundle\Form\Type\MediaType;
use Viweb\CarouselBundle\Entity\Carousel;
use Viweb\RealisationBundle\Entity\Realisation;
use Viweb\SeoBundle\Form\FullSEOType;

class RealisationType extends FullSEOType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, array(
                'required' => true,
                'choices' => array(
                    'Type de projet' => '',
                    'Aménagement paysager' => 'paysagiste',
                )
            ))
            ->add('titre')
            ->add('slug')
            ->add('contenu', CKEditorType::class, array(
                'config' => array(
                    'uiColor' => '#ffffff',
                )
            ))
            ->add('carousel', EntityType::class, array(
                'class' => Carousel::class,
                'choice_label' => 'name',
                'multiple' => false,
                'required' => false
            ))
            ->add('ordre', IntegerType::class, array(
                'attr' => array('min' => 0)
            ));

        //SEO
        parent::buildForm($builder, $options);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Viweb\RealisationBundle\Entity\Realisation'
        ));
    }

    public function getBlockPrefix()
    {
        return 'viweb_realisation_bundle_realisation_type';
    }
}
