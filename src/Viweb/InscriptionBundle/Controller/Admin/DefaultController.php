<?php

namespace Viweb\InscriptionBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Viweb\InscriptionBundle\Entity\Inscription;
use Viweb\InscriptionBundle\Form\InscriptionAdminType;
use Viweb\InscriptionBundle\Form\InscriptionType;


class DefaultController extends Controller
{
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $inscription = $em->getRepository('ViwebInscriptionBundle:Inscription')->find($id);

        $form = $this->get('form.factory')->create(InscriptionType::class, $inscription);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($inscription);
            $em->flush();
            return $this->redirectToRoute('viweb_admin_inscription_single', array('id' => $inscription->getId()));
        }

        // Si le client n'a pas rempli le formulaire on l'envoi sur le formulaire.
        return $this->render('@ViwebInscription/Inscription/Admin/inscription.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    public function envoyeAction($id)
    {
        // On récupère le repository
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('ViwebInscriptionBundle:Inscription');

        // On récupère l'entité correspondante à l'id $id
        $inscription = $repository->find($id);

        // $advert est donc une instance de OC\PlatformBundle\Entity\Advert
        // ou null si l'id $id  n'existe pas, d'où ce if :
        if (null === $inscription) {
            throw new NotFoundHttpException("La inscription d'id " . $id . " n'existe pas.");
        }

        // Le render ne change pas, on passait avant un tableau, maintenant un objet
        return $this->render('ViwebInscriptionBundle:Inscription:envoye.html.twig', array(
            'inscription' => $inscription
        ));
    }

    public function allAction()
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ViwebInscriptionBundle:Inscription');

        $listInscription = $repository->findBy([],['date'=>'DESC']);

        return $this->render('ViwebInscriptionBundle:Inscription/Admin:index.html.twig', array(
            'listInscription' => $listInscription,
        ));

    }

    public function viewAction($id)
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ViwebInscriptionBundle:Inscription');

        $inscription = $repository->findOneById($id);

        return $this->render('ViwebInscriptionBundle:Inscription/Admin:single.html.twig', array(
            'inscription' => $inscription,
        ));

    }

    public function deleteAction(Request $request, Inscription $inscription)
    {
        $em = $this->getDoctrine()->getManager();
        // On crée un formulaire vide, qui ne contiendra que le champ CSRF
        // Cela permet de protéger la suppression d'annonce contre cette faille
        $form = $this->get('form.factory')->create();
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->remove($inscription);
            $em->flush();
            $request->getSession()->getFlashBag()->add('info', "La inscription a bien été supprimée.");
            return $this->redirectToRoute('viweb_admin_inscription_all');
        }

        return $this->render('@ViwebInscription/Inscription/Admin/delete.html.twig', array(
            'inscription' => $inscription,
            'form' => $form->createView(),
        ));
    }

}
