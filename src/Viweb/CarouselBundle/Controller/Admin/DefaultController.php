<?php

namespace Viweb\CarouselBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Viweb\CarouselBundle\Entity\Carousel;
use Viweb\CarouselBundle\Form\Type\CarouselType;

class DefaultController extends Controller
{
    public function ajouterAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $carousel = new Carousel();

        $form = $this->get('form.factory')->create(CarouselType::class, $carousel);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($carousel);
            $em->flush();

            return $this->redirectToRoute('site_admin_carousels');
        }

        return $this->render('@ViwebCarousel/Default/Admin/ajouter.html.twig', array(
            'carousel' => $carousel,
            'form' => $form->createView()
        ));
    }

    public function carouselAction(Request $request, $carousel_id)
    {
        $em = $this->getDoctrine()->getManager();

        $carousel = $em->getRepository('ViwebCarouselBundle:Carousel')->findOneBy(array('id' => $carousel_id));

        $form = $this->get('form.factory')->create(CarouselType::class, $carousel);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($carousel);
            $em->flush();

            return $this->redirectToRoute('site_admin_carousels');
        }

        return $this->render('@ViwebCarousel/Default/Admin/carousel.html.twig', array(
            'carousel' => $carousel,
            'form' => $form->createView()
        ));
    }

    public function carouselsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $carousels = $em->getRepository('ViwebCarouselBundle:Carousel')->findAll();

        return $this->render('@ViwebCarousel/Default/Admin/carousels.html.twig', array('carousels' => $carousels));
    }
}
