<?php

namespace Viweb\ArticleBundle\Controller;

use Viweb\ArticleBundle\Entity\Article;
use Viweb\ArticleBundle\Form\Type\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class ArticleController extends Controller
{
   
    
     public function listArticlesAction(Request $request) {
        
        $em = $this->getDoctrine()->getManager();

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
                
                )
            )
            ->add('date', ChoiceType::class, [
                    'choices'  => [
                        'Toutes' => 0,
                        '2018' => 2018,
                        '2019' => 2019,
                    ],
                ])
            ->add('send', SubmitType::class, array('label' => 'Envoyer'))
            ->getForm();
 
        $formulaire->handleRequest($request);
        if($formulaire->isSubmitted() && $formulaire->isValid()) {
            $ecole = $formulaire['ecole']->getData(); 
            $date = $formulaire['date']->getData(); 
            $articles = $em->getRepository('ViwebArticleBundle:Article')->findAllbyEcoleDate($ecole->getId(), $date);
        } else {

            $articles = $em->getRepository('ViwebArticleBundle:Article')->findDerniersArticles(15);
            
        }
 
        return $this->render('@ViwebArticle/Article/listarticles.html.twig', array(
                'articles' => $articles,
                'form' => $formulaire->createView(),
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
    
    
}
