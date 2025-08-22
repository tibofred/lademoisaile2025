<?php

namespace Viweb\BlogueuseBundle\Controller\Admin;

use Viweb\BlogueuseBundle\Entity\Blogueuse;
use Viweb\BlogueuseBundle\Form\Type\BlogueuseType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



class BlogueuseController extends Controller
{
    public function ajouterAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $blogueuse = new Blogueuse();

        $form = $this->get('form.factory')->create(BlogueuseType::class, $blogueuse);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($blogueuse);
            $em->flush();

            return $this->redirectToRoute('site_admin_blogueuses');
        }

        return $this->render('@ViwebBlogueuse/Blogueuse/Admin/ajouter.html.twig', array(
            'blogueuse' => $blogueuse,
            'form' => $form->createView()
        ));
    }
    
    public function editAction(Request $request, $blogueuse_id)
    {
        $em = $this->getDoctrine()->getManager();

        $blogueuse = $em->getRepository('ViwebBlogueuseBundle:Blogueuse')->findOneBy(array('id' => $blogueuse_id));

        $form = $this->get('form.factory')->create(BlogueuseType::class, $blogueuse);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($blogueuse);
            $em->flush();

            return $this->redirectToRoute('site_admin_blogueuses');
        }

        return $this->render('@ViwebBlogueuse/Blogueuse/Admin/edit.html.twig', array(
            'blogueuse' => $blogueuse,
            'form' => $form->createView()
        ));
    }
    

    public function blogueusesAction()
    {
        
        $user = $this->getUser();
        $roles = $user->getRoles();

        $em = $this->getDoctrine()->getManager();


        if (in_array("ROLE_ADMIN", $roles)) {
            $blogueuses = $em->getRepository('ViwebBlogueuseBundle:Blogueuse')->findBy(
                array(),
                array(
                    'nom' => 'ASC'
                )
            );
        } else {         
            $blogueuses = $em->getRepository('ViwebBlogueuseBundle:Blogueuse')->findByEcole($user->getEcole());
        }


        return $this->render('@ViwebBlogueuse/Blogueuse/Admin/blogueuses.html.twig', array('blogueuses' => $blogueuses));
    }
    
     public function deleteAction(Request $request, $blogueuse_id)
          {
            $em = $this->getDoctrine()->getManager();
            $blogueuse = $em->getRepository('ViwebBlogueuseBundle:Blogueuse')->find($blogueuse_id);
            if (null === $blogueuse) {
              throw new NotFoundHttpException("La blogueuse d'id ".$blogueuse_id." n'existe pas.");
            }
            // On crée un formulaire vide, qui ne contiendra que le champ CSRF
            // Cela permet de protéger la suppression d'annonce contre cette faille
            $form = $this->get('form.factory')->create();
            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
              $em->remove($blogueuse);
              $em->flush();
              $request->getSession()->getFlashBag()->add('info', "La blogueuse a bien été supprimée.");
              return $this->redirectToRoute('site_admin_blogueuses');
            }

            return $this->render('@ViwebBlogueuse/Blogueuse/Admin/delete.html.twig', array(
              'blogueuse' => $blogueuse,
              'form'   => $form->createView(),
            ));
          }
    
    
}


