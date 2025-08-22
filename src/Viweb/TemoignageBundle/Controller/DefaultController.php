<?php

namespace Viweb\TemoignageBundle\Controller;

use Viweb\TemoignageBundle\Entity\Temoignage;
use Viweb\TemoignageBundle\Form\Type\TemoignageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {


        $repository = $this
              ->getDoctrine()
              ->getManager()
              ->getRepository('ViwebTemoignageBundle:Temoignage')
            ;

            $temoignages = $repository->findAll();


        return $this->render('ViwebTemoignageBundle:Temoignage:index.html.twig', array('temoignages' => $temoignages));
    }
}
