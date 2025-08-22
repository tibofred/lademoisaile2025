<?php

namespace Viweb\MediaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;



class MediaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('categorie', ChoiceType::class, array(
                    'choices'  => array(
                        'Journaux' => 'Journaux',
                        'Radio' => 'Radio',
                        'Télévision' => 'Télévision',
                    ),
                ))
            ->add('description', CKEditorType::class, array(
                'config' => array(
                    'uiColor' => '#ffffff',
                )
            ))
            ->add('imageMedia', ImageMediaType::class, array(
                'required' => false
            ))
            ->add('date', DateTimeType::class, array(

            'widget' => 'single_text',

            'attr' => ['class' => 'date_time'],

            'format' => 'yyyy-MM-dd HH:mm',

            'required' => true,

            ))
            ->add('lien');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Viweb\MediaBundle\Entity\Media'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'viweb_mediabundle_media';
    }


}
