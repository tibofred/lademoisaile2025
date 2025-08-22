<?php

namespace Viweb\CarouselBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    public function carouselAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $carousel = $em->getRepository('ViwebCarouselBundle:Carousel')->find($id);
        return $this->render('ViwebCarouselBundle:Default:carousel.html.twig', array('carousel' => $carousel));
    }
}
