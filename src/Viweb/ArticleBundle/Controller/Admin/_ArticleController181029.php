<?php

namespace Viweb\ArticleBundle\Controller\Admin;

use Viweb\ArticleBundle\Entity\Article;
use Viweb\ArticleBundle\Form\Type\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ArticleController extends Controller
{
    public function ajouterAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $article = new Article();

        $usr = $this->getUser();
        $ecole_id = $usr->getEcole()->getID();
        $roles = $usr->getRoles();
        $is_super_admin = false;
        if (in_array("ROLE_ADMIN", $roles)) {
            $is_super_admin = true;
        }

        $form = $this->get('form.factory')->create(ArticleType::class, $article,[
                 'entityManager'       => $this->getDoctrine()->getManager(),
                 'ecole_id'            => $ecole_id,
                 'is_super_admin'      => $is_super_admin
             ]);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('site_admin_article');
        }

        return $this->render('@ViwebArticle/Article/Admin/ajouter.html.twig', array(
            'article' => $article,
            'form' => $form->createView()
        ));
    }   
    
    
    public function editAction(Request $request, $article_id)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('ViwebArticleBundle:Article')->findOneBy(array('id' => $article_id));

        $usr = $this->getUser();
        $ecole_id = $usr->getEcole()->getID();
        $roles = $usr->getRoles();
        $is_super_admin = false;
        if (in_array("ROLE_ADMIN", $roles)) {
            $is_super_admin = true;
        }

        $form = $this->get('form.factory')->create(ArticleType::class, $article,[
                 'entityManager'       => $this->getDoctrine()->getManager(),
                 'ecole_id'            => $ecole_id,
                 'is_super_admin'      => $is_super_admin
             ]);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('site_admin_article');
        }

        return $this->render('@ViwebArticle/Article/Admin/edit.html.twig', array(
            'article' => $article,
            'form' => $form->createView()
        ));
    }
     public function articlesAction()
    {

        $user = $this->getUser();
        $roles = $user->getRoles();

        $em = $this->getDoctrine()->getManager();

        if (in_array("ROLE_ADMIN", $roles)) {
            $articles = $em->getRepository('ViwebArticleBundle:Article')->findBy(
                array(),
                array(
                    'id' => 'ASC',
                    'titre' => 'ASC'
                )
            );
        } else { 
            $articlesRepository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('ViwebArticleBundle:Article');
            
            
            $articles = $articlesRepository->findAllbyEcole($user->getEcole());
        }
            return $this->render('@ViwebArticle/Article/Admin/articles.html.twig', array(
                'articles' => $articles
            ));
        }
    
    
    public function ecoleAction($ecole_id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $blogueuses = $em->getRepository('ViwebBlogueuseBundle:Blogueuse')->findBlogueuseByEcoleId($ecole_id);
       
        // $articles = $em->getRepository('ViwebArticleBundle:Article')->findByEcole($ecole_id);

        return $this->render('@ViwebArticle/Article/Admin/articles-ecole.html.twig', array(
            'blogueuses' => $blogueuses
        ));
    }
    
    
     public function deleteAction(Request $request, $article_id)
          {
            $em = $this->getDoctrine()->getManager();
            $article = $em->getRepository('ViwebArticleBundle:Article')->find($article_id);
            if (null === $article) {
              throw new NotFoundHttpException("L'article d'id ".$article_id." n'existe pas.");
            }
            // On crée un formulaire vide, qui ne contiendra que le champ CSRF
            // Cela permet de protéger la suppression d'annonce contre cette faille
            $form = $this->get('form.factory')->create();
            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
              $em->remove($article);
              $em->flush();
              $request->getSession()->getFlashBag()->add('info', "L'article a bien été supprimée.");
              return $this->redirectToRoute('site_admin_article');
            }

            return $this->render('@ViwebArticle/Article/Admin/delete.html.twig', array(
              'article' => $article,
              'form'   => $form->createView(),
            ));
          }
    
    
}
