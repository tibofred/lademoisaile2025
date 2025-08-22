<?php

namespace Viweb\ArticleBundle\Controller\Article;

use Viweb\ArticleBundle\Entity\Article;
use Viweb\ArticleBundle\Form\Type\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ArticleController extends Controller
{
   
    
    
     public function articlesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('ViwebArticleBundle:Article')->findBy(
            array(),
            array(
                'id' => 'ASC',
                'titre' => 'ASC'
            )
        );

        return $this->render('@ViwebArticle/Article/Admin/articles.html.twig', array(
            'articles' => $articles
        ));
    }
    
    public function editAction(Request $request, $article_id)
   
    
    
}
