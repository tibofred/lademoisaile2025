<?php

namespace Viweb\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
   public function buildForm(FormBuilderInterface $builder, array $options)
   {
       $builder->add('nom');
   }
 
    public function getParent()
   {
       return 'FOSUserBundleFormTypeRegistrationFormType';
 
   }
 
   public function getBlockPrefix()
   {
       return 'app_user_registration';
   }
}