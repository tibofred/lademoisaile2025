<?php

namespace Viweb\ArticleBundle\Form\Type;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Viweb\BlogueuseBundle\Repository\BlogueuseRepository;
use Viweb\ArticleBundle\Repository\CategorieRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Viweb\SeoBundle\Form\FullSEOType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormEvents;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityManager;

use ViwebBlogueuseBundle\Entity\Blogueuse;

class ArticleType extends FullSEOType
{

   /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $em = $options['entityManager'];
        $ecole_id = $options['ecole_id'];
        $is_super_admin = $options['is_super_admin'];

        $repoBlogueuse = $em->getRepository('ViwebBlogueuseBundle:Blogueuse');
        if($is_super_admin) {            
            $blogeuses = $repoBlogueuse->getBlogueuseforselect();
        }  else {
            $blogeuses = $repoBlogueuse->createQueryBuilder("q")
                ->where("q.ecole = :ecole_id")
                ->setParameter("ecole_id", $ecole_id)
                ->getQuery()
                ->getResult();
        }

        $builder
            ->add('titre')
            
            ->add('slug')
            
             ->add('description', CKEditorType::class, array(
                'config' => array(
                    'uiColor' => '#ffffff',
                )
            ))
            
             ->add('contenu', CKEditorType::class, array(
                'config' => array(
                    'uiColor' => '#ffffff',
                )
            ))
                        
            ->add('blogueuse', ChoiceType::class, [
                    'choices' => $blogeuses
            ])
            /*->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
                $blogueuse = $event->getData(); 
                $event->getForm()->add('user', EntityType::class, array(
                    'class' => 'ViwebBlogueuseBundle:Blogueuse',
                    'choice_label' => function ($allChoices, $currentChoiceKey)
                        
                        {
                            return $allChoices->getPrenom() . " " . $allChoices->getNom();
                        },
                    'query_builder' => function (UserRepository $ur) use ($blogueuse) {
                                       return $ur->findBlogueuseByEcoleId($blogueuse->getEcole());

                    },
                ));
            })*/
            
            ->add('datePublication', DateTimeType::class, array(

            'widget' => 'single_text',

            'format' => 'yyyy-MM-dd HH:mm',

            'required' => true,

            ))
            
            ->add('datePlanification', DateTimeType::class, array(

            'widget' => 'single_text',

            'format' => 'yyyy-MM-dd HH:mm',

            'required' => true,
            

            ))
            ->add('brouillon')
            
            ->add('photo',     PhotoType::class, array(
                'required' => false
            ))
                        
             ->add('categorie', EntityType::class, array(
                
                'class' => 'ViwebArticleBundle:Categorie',
                'choice_label' =>  'nom',
            ))
            
            ->add('anneScolaire', ChoiceType::class, array(
                'choices' => array(
                    'Secondaire 1'  => 1,
                    'Secondaire 2'  => 2,
                    'Secondaire 3'  => 3,
                    'Secondaire 4'  => 4,
                    'Secondaire 5'  => 5,
                    'Pré-DEP'       => 6,
                    'Parcours'      => 7,
                    'Membre du personnel'      => 8,
                )));
        
        
        //SEO
        parent::buildForm($builder, $options);
            
            
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'Viweb\ArticleBundle\Entity\Article',
            'entityManager'     => null,
            'is_super_admin'    => null,
            'ecole_id'          => null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'viweb_articlebundle_article';
    }


}
