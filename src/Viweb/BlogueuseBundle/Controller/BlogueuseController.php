<?php

namespace Viweb\BlogueuseBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogueuseController extends Controller
{
    
    public function ecoleAction($ecole_slug, Request $request)
    {
    
        
        $repo = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ViwebEcoleBundle:Ecole');
        
        
        $ecole = $repo->findOneBySlug($ecole_slug);
        
        
        
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ViwebEcoleBundle:Ecole');
        
        
        $id = $repository->findIdBySlug($ecole_slug);
        
        
        
        
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ViwebBlogueuseBundle:Blogueuse');
        
        $blogueuses = $repository->findByEcole($id, $archive='no');

        $rep = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ViwebArticleBundle:Article');
        
        $arra_blog = array ();
        if(sizeof($blogueuses)>0) {
            foreach($blogueuses as $blog) {
                $articles = $rep->myFindAll($blog->getId());
                $blog->countarticle = sizeof($articles);
                $arra_blog[] = $blog;
            }
        }
        
        
        
        return $this->render('ViwebBlogueuseBundle:Blogueuse:blogueuses-ecole.html.twig', array(
            
            'blogueuses' => $arra_blog,
            'ecole' => $ecole,
            
        ));
        
    }
    
    
    public function profilAction($blogueuse_id, $ecole_slug, Request $request)
    {
        
        $repo = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ViwebEcoleBundle:Ecole');
        $ecole = $repo->findOneBySlug($ecole_slug);
        

        

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ViwebBlogueuseBundle:Blogueuse');
        $blogueuse = $repository->findById($blogueuse_id);
        
        
        $rep = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ViwebArticleBundle:Article');
        
        $articles = $rep->myFindByBlogueuse($blogueuse_id);
        
        
        return $this->render('ViwebBlogueuseBundle:Blogueuse:profil.html.twig', array(
            
            'blogueuse' => $blogueuse,
            'ecole' => $ecole,
            'articles' => $articles
            
        ));
        
    }
    
    
    
    public function articleAction($blogueuse_id, $ecole_slug, $article_slug, Request $request)
    {
        
        $repo = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ViwebEcoleBundle:Ecole');
        $ecole = $repo->findOneBySlug($ecole_slug);
        

        

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ViwebBlogueuseBundle:Blogueuse');
        $blogueuse = $repository->findById($blogueuse_id);
        
        
        $rep = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ViwebArticleBundle:Article');
        
        $article = $rep->findOneBySlug($article_slug);

        $articlesRepository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ViwebArticleBundle:Article');
        $articles = $articlesRepository->findDerniersArticles(3);
        
        
        return $this->render('ViwebBlogueuseBundle:Blogueuse:article.html.twig', array(
            
            'blogueuse' => $blogueuse[0],
            'ecole' => $ecole,
            'article' => $article,
            'articles' => $articles,
            
        ));
        
    }
    
    
    
    
    
}
