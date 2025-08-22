<?php

namespace SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PromotionController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $bloc_promotions = $em->getRepository('SiteBundle:Bloc')->findOneBy(array('name' => 'promotions'));

        $promotions = $em->getRepository('SiteBundle:Promotion')->findAllActive();

        return $this->render('@Site/Promotion/index.html.twig', array(
            'bloc_promotions' => $bloc_promotions,
            'promotions' => $promotions
        ));
    }
}
