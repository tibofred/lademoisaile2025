<?php

namespace Viweb\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Viweb\EcoleBundle\Repository\EcoleRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class ProfilType extends AbstractType
{
   public function buildForm(FormBuilderInterface $builder, array $options)
   {
       $builder
           ->add('nom')
           ->add('prenom')
           
           ->add('description', CKEditorType::class, array(
                'config' => array(
                    'uiColor' => '#ffffff',
                )
            ))
           
           ->add('titre', CKEditorType::class, array(
                'config' => array(
                    'uiColor' => '#ffffff',
                )
            ))
           
           ->add('courteDescription', CKEditorType::class, array(
                'config' => array(
                    'uiColor' => '#ffffff',
                )
            ))
           
           ->add('avatar',     AvatarType::class, array(
                'required' => false
            ))
           
           ->add('ecole', EntityType::class, array(
                
                'class' => 'ViwebEcoleBundle:Ecole',
                'choice_label' => 'nom',
            ))
           ;
   }
 
    public function getParent()
   {
       return 'FOS\UserBundle\Form\Type\ProfileFormType';
 
   }
 
   public function getBlockPrefix()
   {
       return 'app_user_profile';
   }
}