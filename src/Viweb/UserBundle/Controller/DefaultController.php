<?php

namespace Viweb\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
   
    
    public function listeAction()
    {
        
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('ViwebUserBundle:User')->findall();

        
        return $this->render('ViwebUserBundle:Admin:liste.html.twig', array(
            'users' => $users,
        ));
    }
}
