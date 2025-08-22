<?php

namespace Viweb\InscriptionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class InscriptionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('nomEcole', ChoiceType::class, array(
                    'choices'  => array(
                        'École secondaire Augustin-Norbert Morin' => 'augustin-norbert-morin',
                        'École secondaire Curé-Mercure' => 'cure-mercure',
                        'École secondaire des Trois-Saisons' => 'ecole-secondaire-des-trois-saisons',
                        'École secondaire de Gracefield' => 'ecole-secondaire-de-gracefield',
                        'École secondaire de Mirabel' => 'ecole-secondaire-de-mirabel',
                        'École secondaire Émilien-Frenette' => 'emilien-frenette',
                        'École secondaire Liberté Jeunesse' => 'liberte-jeunesse',
                        'École secondaire Poly-Jeunesse' => 'ecole-secondaire-poly-jeunesse',
                        'La Polyvalente des Monts' => 'la-polyvalente-des-monts',
                        'École secondaire Cap-Jeunesse' => 'cap-jeunesse',
                        'École secondaire La Source' => 'ecole-secondaire-la-source',
                        'École secondaire d’Amos – La Forêt' => 'la-foret',
                        'Polyvalente Deux-Montagnes' => 'polyvalente-deux-montagnes',
                        'Nouvelle école secondaire de Mirabel' => 'nouvelle-ecole-secondaire-de-mirabel',
                        'Polyvalente St-Jérôme' => 'polyvalente-st-jerome',
                    ),
                ))
            /*->add('nomEcole', EntityType::class, array(
                'class' => \Viweb\EcoleBundle\Entity\Ecole::class,
                'query_builder' => function (\Viweb\EcoleBundle\Repository\EcoleRepository $repo) {
                    return $repo->createAlphabeticalQueryBuilder();
                 },
                'choice_label' => 'nom',
                'label' => 'Ecole:',

                    'required' => false,
                )
            ) */   
            ->add('nom')
            ->add('prenom')
            ->add('courriel')
            ->add('facebook', TextType::class, array(
                'required' => false,
            ))
            ->add('instagram', TextType::class, array(
                'required' => false,
            ))
            ->add('date',      DateTimeType::class)
            ->add('description')
            ->add('article')
            ->add('Envoyer', SubmitType::class);

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Viweb\InscriptionBundle\Entity\Inscription'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'viweb_inscriptionbundle_inscription';
    }


}
