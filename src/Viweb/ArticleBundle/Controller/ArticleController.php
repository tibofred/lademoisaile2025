<?php

namespace Viweb\ArticleBundle\Controller;

use Viweb\ArticleBundle\Entity\Article;
use Viweb\ArticleBundle\Form\Type\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class ArticleController extends Controller
{


     public function listArticlesAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $name_b = "";

        $search = NULL;
        $formulaire = $this->createFormBuilder()
            //->add('ecole', EntityType::class, [ 'class' => \Viweb\EcoleBundle\Entity\Ecole::class, 'choice_label' => 'Ecole'])
            ->add('ecole', EntityType::class, array(
                'class' => \Viweb\EcoleBundle\Entity\Ecole::class,
                'query_builder' => function (\Viweb\EcoleBundle\Repository\EcoleRepository $repo) {
                    return $repo->createAlphabeticalQueryBuilder();
                 },
                'choice_label' => 'nom',
                'label' => 'Ecole:',

                    'required' => false,
                )
            )
            ->add('date', ChoiceType::class, [
                    'choices'  => [
                        'Toutes' => 0,
                        '2024-2025' => 2025,
                        '2023-2024' => 2024,
                        '2022-2023' => 2023,
                        '2021-2022' => 2022,
                        '2020-2021' => 2021,
                        '2019-2020' => 2020,
                        '2018-2019' => 2019,
                        '2017-2018' => 2018,

                    ],
            ])
            /*->add('blogueuse', TextType::class, [
                    'required' => false,
                ])*/
            ->add('blogueuse', EntityType::class, array(
                'class' => \Viweb\BlogueuseBundle\Entity\Blogueuse::class,
                'query_builder' => function (\Viweb\BlogueuseBundle\Repository\BlogueuseRepository $repo) {
                    return $repo->createAlphabeticalQueryBuilder();
                 },
                'choice_label' =>  function ($blogueuse) {
                        return $blogueuse->getPrenom().' '.$blogueuse->getNom();
                    },
                'label' => 'Blogueuse:',

                    'required' => false,
                )
            )
            ->add('send', SubmitType::class, array('label' => 'Envoyer'))
            ->getForm();

        $formulaire->handleRequest($request);
        if($formulaire->isSubmitted() && $formulaire->isValid()) {
            $ecole = $formulaire['ecole']->getData();
            $date = $formulaire['date']->getData();
            $blogueuse = $formulaire['blogueuse']->getData();
            
            if(empty($ecole) && empty($date)) {
                $larticles = $em->getRepository('ViwebArticleBundle:Article')->findDerniersArticles(60);
            } else {
                if(!empty($ecole)) {
                   $larticles = $em->getRepository('ViwebArticleBundle:Article')->findAllbyEcoleDate($ecole->getId(), $date);
                } else {
                    $larticles = $em->getRepository('ViwebArticleBundle:Article')->findAllbyEcoleDate('', $date);
                }
            }
            
            if(!empty($blogueuse)) {
                $blogs = $em->getRepository('ViwebBlogueuseBundle:Blogueuse')->findById($blogueuse);

                if(empty($ecole) && empty($date)) {
                    $larticles = $em->getRepository('ViwebArticleBundle:Article')->findDerniersArticles(3000);
                }

                if(sizeof($blogs)>0) {
                    foreach($blogs as $blog) {
                        $name_b = $blog->getPrenom().' '.$blog->getNom();
                        $idblog = $blog;
                    }                    
                }
                $articles = [];
                if(sizeof($larticles)>0) {
                    foreach($larticles as $article) {
                        if($idblog == $article->getBlogueuse()) {
                            $articles[] = $article;          
                        }
                    }
                    
                }
            } else {
                $articles = $larticles;          
            }
            
            
            

        } else {

            $articles = $em->getRepository('ViwebArticleBundle:Article')->findDerniersArticles(60);

        }
        
        $blogueuses = $em->getRepository('ViwebBlogueuseBundle:Blogueuse')->getBlogueuseautocomplete();

        return $this->render('@ViwebArticle/Article/listarticles.html.twig', array(
                'articles' => $articles,
                'blogueuses' => $blogueuses,
                'blogueuse'  => $name_b,
                'form' => $formulaire->createView(),
        ));

    }


     public function listArticlesJourneefemmeAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('ViwebArticleBundle:Article')->findJourneeArticles(60);

        return $this->render('@ViwebArticle/Article/listarticlesjourneefemme.html.twig', array(
                'articles' => $articles
        ));

    }


     public function listArticlesLettreaineesAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('ViwebArticleBundle:Article')->findLaineeArticles(60);

        return $this->render('@ViwebArticle/Article/listarticleslettreaineesAction.html.twig', array(
                'articles' => $articles
        ));

    }


     public function listArticlesLettreblogueusesAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('ViwebArticleBundle:Article')->findLblogArticles(60);

        return $this->render('@ViwebArticle/Article/listarticleslettreblogueuses.html.twig', array(
                'articles' => $articles
        ));
    }




     public function listArticlesArchiveAction() {
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('ViwebArticleBundle:Article')->listArticlesArchives();

        return $this->render('@ViwebArticle/Article/listarticlesarchive.html.twig', array(
            'articles' => $articles
        ));
    }



    public function searchAction(Request $request)
    {
        $search = NULL;
        $formulaire = $this->createFormBuilder()
            ->add('ecole', EntityType::class, [ 'class' => Ecole::class, 'choice_label' => 'Ecole'])
            ->add('send', SubmitType::class, array('label' => 'Envoyer'))
            ->getForm();

        $formulaire->handleRequest($request);
        if($formulaire->isSubmitted() && $formulaire->isValid()) {
            $search = $formulaire['search']->getData();
            return $this->redirectToRoute('site_liste_articles', array('search' => $search));
        }

        return['formulaire' => $formulaire->createView()];
    }



    public function articlescategorieAction(Request $request, $categorie_id)
    {

        $em = $this->getDoctrine()->getManager();

        $articlesRepository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ViwebArticleBundle:Article');


        $articles = $articlesRepository->findAllbyCategorie($categorie_id);

        $categorie = $em->getRepository('ViwebArticleBundle:Categorie')->findOneBy(array('id' => $categorie_id));

        return $this->render('ViwebArticleBundle:Article:articles-categories.html.twig', array(
            'articles' => $articles,
            'categorie' => $categorie
        ));;



    }

    public function articlescategoriegroupAction(Request $request, $group)
    {
        $arr_cats = array();
        $arr_cats['çavabienaller'] = [1];
        $arr_cats['Ilfautenparler'] = [2,3,34,4,5,6,7,8,9];
        $arr_cats['unmondeàdécouvrir'] = [10,11,12,31,13,33,14,15,16,30,32];
        $arr_cats['lenvironnementtatouésurlecœur'] = [17];
        $arr_cats['tunespasseule'] = [18,35,19,20,21,22,23,24,25];
        $arr_cats['vasytescapable'] = [26,27,29];
        $em = $this->getDoctrine()->getManager();

        $articlesRepository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ViwebArticleBundle:Article');


        $articles = $articlesRepository->findAllbyCategorieGroup($arr_cats[$group]);


        return $this->render('ViwebArticleBundle:Article:articles-categories-groupe.html.twig', array(
            'articles' => $articles,
            'group'    => $group
        ));;



    }



     public function categoriesAction() {

        return $this->render('@ViwebArticle/Article/categories.html.twig', array(

        ));
    }




}
