<?php

namespace SiteBundle\Controller\Admin;

use SiteBundle\Entity\Ressource;
use SiteBundle\Form\Type\RessourceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RessourceController extends Controller
{
    public function indexAction()
    {
        return new Response("ADMIN TODO");
    }

    public function ajouterAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $ressource = new Ressource();

        $form = $this->get('form.factory')->create(RessourceType::class, $ressource);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($ressource);
            $em->flush();

            return $this->redirectToRoute('site_admin_ressources');
        }

        return $this->render('@Site/Ressource/Admin/ajouter.html.twig', array(
            'ressource' => $ressource,
            'form' => $form->createView()
        ));
    }

    public function ressourceAction(Request $request, $ressource_id, $ressource_slug)
    {
        $em = $this->getDoctrine()->getManager();

        $ressource = $em->getRepository('SiteBundle:Ressource')->findOneBy(array('id' => $ressource_id));

        $form = $this->get('form.factory')->create(RessourceType::class, $ressource);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($ressource);
            $em->flush();

            return $this->redirectToRoute('site_admin_ressources');
        }

        return $this->render('@Site/Ressource/Admin/ressource.html.twig', array(
            'ressource' => $ressource,
            'form' => $form->createView()
        ));
    }

    public function ressourcesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ressources = $em->getRepository('SiteBundle:Ressource')->findBy(
            array(),
            array(
                'id' => 'ASC',
                'ordre' => 'ASC'
            )
        );

        return $this->render('@Site/Ressource/Admin/ressources.html.twig', array('ressources' => $ressources));
    }
    
    
    
    
    public function showAction(Request $request, $ressource_slug)
    {
        
        $em = $this->getDoctrine()->getManager();

        $ressource = $em->getRepository('SiteBundle:Ressource')->findOneBy(array('slug' => $ressource_slug));
        
        
        return $this->render('@Site/Ressource/Admin/show.html.twig', array('ressource' => $ressource));
    }
    
    
    
}
