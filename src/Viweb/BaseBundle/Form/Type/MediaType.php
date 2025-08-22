<?php
/**
 * Created by PhpStorm.
 * User: pmdc
 * Date: 24/01/17
 * Time: 11:56 AM
 */

namespace Viweb\BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('path', FileType::class, [
            'label' => 'Fichier Media',
            'data_class' => null
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Viweb\BaseBundle\Entity\Media',
        ));
    }

    public function getBlockPrefix()
    {
        return 'viweb_base_bundle_media_type';
    }
}