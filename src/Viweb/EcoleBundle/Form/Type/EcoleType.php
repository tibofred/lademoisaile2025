<?php

namespace Viweb\EcoleBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Viweb\EcoleBundle\Repository\RegionRepository;
use Viweb\EcoleBundle\Repository\CommissionRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class EcoleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('slug')
            ->add('email')
            ->add('adresse')
            ->add('ville')
            ->add('responsable')
            ->add('titreResponsable')
            ->add('codepostal')
            ->add('telephone')
            
            ->add('imgResponsable',  imgResponsableType::class, array(
                'required' => false
            ))
            
            ->add('region', EntityType::class, array(
                
                'class' => 'ViwebEcoleBundle:Region',
                'choice_label' => 'nom',
            ))
            
            ->add('commission', EntityType::class, array(
                
                'class' => 'ViwebEcoleBundle:Commission',
                'choice_label' => 'nom',
            ))
            
            ->add('logo',  LogoType::class, array(
                'required' => false
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
            'data_class' => 'Viweb\EcoleBundle\Entity\Ecole'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'viweb_ecolebundle_ecole';
    }


}
