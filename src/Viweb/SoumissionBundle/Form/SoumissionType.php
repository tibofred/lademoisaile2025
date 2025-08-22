<?php

namespace Viweb\SoumissionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;


class SoumissionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('nomEcole')
            ->add('commissionScolaire')
            ->add('typeContact', ChoiceType::class, array(
                    'choices'  => array(
                        'Un (e) étudiant (e)' => 'etudiant',
                        'Un membre du personnel' => 'personnel',
                        'Un parent' => 'parent',
                        'Aucune de ces réponses' => 'Aucune',
                    ),
                ))
            ->add('region')
            ->add('nom')
            ->add('prenom')
            ->add('telephone')
            ->add('courriel')
            ->add('date',      DateTimeType::class)
            ->add('message')
            ->add('Envoyer', SubmitType::class);

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Viweb\SoumissionBundle\Entity\Soumission'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'viweb_soumissionbundle_soumission';
    }


}
