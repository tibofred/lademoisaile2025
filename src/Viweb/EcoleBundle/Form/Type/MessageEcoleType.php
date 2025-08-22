<?php

namespace Viweb\EcoleBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageEcoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', TextType::class, array(
                'label' => 'firstname',
            ))
            ->add('nom', TextType::class, array(
                'label' => 'lastname',
            ))
            ->add('courriel', TextType::class, array(
                'label' => 'email',
            ))
            ->add('telephone', TextType::class, array(
                'label' => 'phone',
            ))
            ->add('message', TextareaType::class)
            ->add('send', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Viweb\EcoleBundle\Entity\MessageEcole',
            'translation_domain' => 'contact'
        ));
    }

    public function getBlockPrefix()
    {
        return 'viweb_ecole_bundle_messageecole';
    }
}
