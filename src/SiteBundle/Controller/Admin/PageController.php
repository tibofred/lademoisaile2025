<?php

namespace SiteBundle\Controller\Admin;

use SiteBundle\Entity\Page;
use SiteBundle\Form\Type\PageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PageController extends Controller
{
    public function indexAction()
    {
        return new Response("ADMIN TODO");
    }

    public function ajouterAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $page = new Page();

        $form = $this->get('form.factory')->create(PageType::class, $page);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($page);
            $em->flush();

            return $this->redirectToRoute('site_admin_pages');
        }

        return $this->render('@Site/Page/Admin/ajouter.html.twig', array(
            'page' => $page,
            'form' => $form->createView()
        ));
    }

    public function pageAction(Request $request, $page_id, $page_slug)
    {
        $em = $this->getDoctrine()->getManager();

        $page = $em->getRepository('SiteBundle:Page')->findOneBy(array('id' => $page_id));

        $form = $this->get('form.factory')->create(PageType::class, $page);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($page);
            $em->flush();

            return $this->redirectToRoute('site_admin_pages');
        }

        return $this->render('@Site/Page/Admin/page.html.twig', array(
            'page' => $page,
            'form' => $form->createView()
        ));
    }

    public function pagesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pages = $em->getRepository('SiteBundle:Page')->findBy(
            array(),
            array(
                'id' => 'ASC',
                'ordre' => 'ASC'
            )
        );

        return $this->render('@Site/Page/Admin/pages.html.twig', array('pages' => $pages));
    }
    
    
    public function deleteAction(Request $request, $page_id)
          {
            $em = $this->getDoctrine()->getManager();
            $page = $em->getRepository('SiteBundle:Page')->find($page_id);
            if (null === $page) {
              throw new NotFoundHttpException("La page d'id ".$page_id." n'existe pas.");
            }
            // On crée un formulaire vide, qui ne contiendra que le champ CSRF
            // Cela permet de protéger la suppression d'annonce contre cette faille
            $form = $this->get('form.factory')->create();
            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
              $em->remove($page);
              $em->flush();
              $request->getSession()->getFlashBag()->add('info', "La page a bien été supprimée.");
              return $this->redirectToRoute('site_admin_pages');
            }

            return $this->render('@Site/Page/Admin/delete.html.twig', array(
              'page' => $page,
              'form'   => $form->createView(),
            ));
          }
}
