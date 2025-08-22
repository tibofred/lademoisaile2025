<?php

namespace SiteBundle\Controller\Admin;

use SiteBundle\Entity\Bloc;
use SiteBundle\Entity\Page;
use SiteBundle\Form\Type\BlocType;
use SiteBundle\Form\Type\PageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BlocController extends Controller
{
    public function ajouterAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $bloc = new Bloc();

        $form = $this->get('form.factory')->create(BlocType::class, $bloc);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($bloc);
            $em->flush();

            return $this->redirectToRoute('site_admin_blocs');
        }

        return $this->render('@Site/Page/Admin/ajouter.html.twig', array(
            'bloc' => $bloc,
            'form' => $form->createView()
        ));
    }

    public function blocAction(Request $request, $bloc_id, $bloc_name)
    {
        $em = $this->getDoctrine()->getManager();

        $bloc = $em->getRepository('SiteBundle:Bloc')->findOneBy(array('id' => $bloc_id));

        $form = $this->get('form.factory')->create(BlocType::class, $bloc);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($bloc);
            $em->flush();

            return $this->redirectToRoute('site_admin_blocs');
        }

        return $this->render('@Site/Bloc/Admin/bloc.html.twig', array(
            'bloc' => $bloc,
            'form' => $form->createView()
        ));
    }

    public function blocsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $blocs = $em->getRepository('SiteBundle:Bloc')->findBy(
            array(),
            array(
                'id' => 'ASC',
                'ordre' => 'ASC'
            )
        );

        return $this->render('@Site/Bloc/Admin/blocs.html.twig', array('blocs' => $blocs));
    }
}
