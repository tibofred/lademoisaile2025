<?php

namespace Viweb\RealisationBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Viweb\RealisationBundle\Entity\Realisation;
use Viweb\RealisationBundle\Form\Type\RealisationType;

class RealisationController extends Controller
{
    public function ajouterAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $realisation = new Realisation();

        $form = $this->get('form.factory')->create(RealisationType::class, $realisation);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($realisation);
            $em->flush();

            return $this->redirectToRoute('site_admin_realisation_realisations');
        }

        return $this->render('@ViwebCarousel/Default/Admin/ajouter.html.twig', array(
            'realisation' => $realisation,
            'form' => $form->createView()
        ));
    }

    public function realisationAction(Request $request, $realisation_id, $realisation_slug)
    {
        $em = $this->getDoctrine()->getManager();

        $realisation = $em->getRepository('ViwebRealisationBundle:Realisation')->findOneBy(array('id' => $realisation_id));

        $form = $this->get('form.factory')->create(RealisationType::class, $realisation);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($realisation);
            $em->flush();

            return $this->redirectToRoute('site_admin_realisation_realisations');
        }

        return $this->render('@ViwebRealisation/Page/Admin/realisation.html.twig', array(
            'realisation' => $realisation,
            'form' => $form->createView()
        ));
    }

    public function realisationsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $realisations = $em->getRepository('ViwebRealisationBundle:Realisation')->findBy(
            array(),
            array(
                'id' => 'ASC',
                'ordre' => 'ASC'
            )
        );

        return $this->render('@ViwebRealisation/Page/Admin/realisations.html.twig', array('realisations' => $realisations));
    }
}
