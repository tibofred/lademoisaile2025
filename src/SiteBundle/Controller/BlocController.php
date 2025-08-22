<?php

namespace SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class BlocController extends Controller
{
    public function displayBlocAction($bloc_name)
    {
        $em = $this->getDoctrine()->getManager();

        $bloc = $em->getRepository('SiteBundle:Bloc')->findOneBy(array('name' => $bloc_name));
        if ($bloc === null)
            return new Response("");
        return new Response($bloc->getContenu());
    }
}
