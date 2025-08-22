<?php

namespace Viweb\ArticleBundle\Controller;

use Viweb\ArticleBundle\Entity\Article;
use Viweb\ArticleBundle\Form\Type\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ArticleController extends Controller
{
   
    
     public function listArticlesAction() {
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('ViwebArticleBundle:Article')->findDerniersArticles(15);

        return $this->render('@ViwebArticle/Article/listarticles.html.twig', array(
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
    
    
}
