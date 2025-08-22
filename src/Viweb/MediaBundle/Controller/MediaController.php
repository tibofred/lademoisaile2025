<?php

namespace Viweb\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MediaController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $medias_journaux = $em->getRepository('ViwebMediaBundle:Media')->findBy(
            array('categorie' => 'Journaux'),
            array(
                'date' => 'DESC'
            )
        );
        $medias_radio = $em->getRepository('ViwebMediaBundle:Media')->findBy(
            array('categorie' => 'Radio'),
            array(
                'date' => 'DESC'
            )
        );
        $medias_tv = $em->getRepository('ViwebMediaBundle:Media')->findBy(
            array('categorie' => 'Télévision'),
            array(
                'date' => 'DESC'
            )
        );
        
        return $this->render('@ViwebMedia/Default/index.html.twig', array(
                    'medias_journaux'   => $medias_journaux,
                    'medias_radio'      => $medias_radio,
                    'medias_tv'         => $medias_tv,
                ));
    }
    

    
    
}
