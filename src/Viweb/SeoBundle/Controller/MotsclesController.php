<?php

namespace Viweb\SeoBundle\Controller;

use Viweb\SeoBundle\Entity\Motscles;
use Viweb\SeoBundle\Form\MotsclesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MotsclesController extends Controller
{
    
    
    public function addAction(Request $request)
      {
        $motscles = new Motscles();
        $form   = $this->get('form.factory')->create(MotsclesType::class, $motscles);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($motscles);
          $em->flush();
          $request->getSession()->getFlashBag()->add('notice', 'Mots cles enregistre');
          return $this->redirectToRoute('viweb_base_homepage');
        }
        return $this->render('ViwebSeoBundle:Motscles:add.html.twig', array(
          'form' => $form->createView(),
        ));
      }
    
}
