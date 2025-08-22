<?php

namespace Viweb\SoumissionBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Viweb\SoumissionBundle\Entity\Soumission;
use Viweb\SoumissionBundle\Form\SoumissionAdminType;
use Viweb\SoumissionBundle\Form\SoumissionType;


class DefaultController extends Controller
{
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $soumission = $em->getRepository('ViwebSoumissionBundle:Soumission')->find($id);

        $form = $this->get('form.factory')->create(SoumissionType::class, $soumission);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($soumission);
            $em->flush();
            return $this->redirectToRoute('viweb_admin_soumission_single', array('id' => $soumission->getId()));
        }

        // Si le client n'a pas rempli le formulaire on l'envoi sur le formulaire.
        return $this->render('@ViwebSoumission/Soumission/Admin/soumission.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    public function envoyeAction($id)
    {
        // On récupère le repository
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('ViwebSoumissionBundle:Soumission');

        // On récupère l'entité correspondante à l'id $id
        $soumission = $repository->find($id);

        // $advert est donc une instance de OC\PlatformBundle\Entity\Advert
        // ou null si l'id $id  n'existe pas, d'où ce if :
        if (null === $soumission) {
            throw new NotFoundHttpException("La soumission d'id " . $id . " n'existe pas.");
        }

        // Le render ne change pas, on passait avant un tableau, maintenant un objet
        return $this->render('ViwebSoumissionBundle:Soumission:envoye.html.twig', array(
            'soumission' => $soumission
        ));
    }

    public function allAction()
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ViwebSoumissionBundle:Soumission');

        $listSoumission = $repository->findAll();

        return $this->render('ViwebSoumissionBundle:Soumission/Admin:index.html.twig', array(
            'listSoumission' => $listSoumission,
        ));

    }

    public function viewAction($id)
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ViwebSoumissionBundle:Soumission');

        $soumission = $repository->findOneById($id);

        return $this->render('ViwebSoumissionBundle:Soumission/Admin:single.html.twig', array(
            'soumission' => $soumission,
        ));

    }

    public function deleteAction(Request $request, Soumission $soumission)
    {
        $em = $this->getDoctrine()->getManager();
        // On crée un formulaire vide, qui ne contiendra que le champ CSRF
        // Cela permet de protéger la suppression d'annonce contre cette faille
        $form = $this->get('form.factory')->create();
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->remove($soumission);
            $em->flush();
            $request->getSession()->getFlashBag()->add('info', "La soumission a bien été supprimée.");
            return $this->redirectToRoute('viweb_admin_soumission_all');
        }

        return $this->render('@ViwebSoumission/Soumission/Admin/delete.html.twig', array(
            'soumission' => $soumission,
            'form' => $form->createView(),
        ));
    }

}
