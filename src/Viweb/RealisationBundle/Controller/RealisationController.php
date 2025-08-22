<?php

namespace Viweb\RealisationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class RealisationController extends Controller
{
    public function indexAction($realisation_type, $realisation_slug)
    {
        $em = $this->getDoctrine()->getManager();

        $realisation = $em->getRepository('ViwebRealisationBundle:Realisation')->findOneBy(array(
            'slug' => $realisation_slug,
            'type' => $realisation_type
        ));

        if ($realisation == null) {
            return new Response(
                $this->renderView(':errors:404.html.twig', array(
                )),
                404  // return code
            );
        }

        return $this->render('ViwebRealisationBundle:Page:index.html.twig', array(
            'realisation' => $realisation,
        ));
    }
}
