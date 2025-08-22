<?php

namespace Viweb\MediaBundle\Controller\Admin;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Viweb\MediaBundle\Entity\Media;
use Viweb\MediaBundle\Form\Type\MediaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MediaController extends Controller
{
    
    public function ajouterAction(Request $request)
        {
            $em = $this->getDoctrine()->getManager();

            $media = new Media();

            $form = $this->get('form.factory')->create(MediaType::class, $media);
            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
                $em->persist($media);
                $em->flush();

                return $this->redirectToRoute('site_admin_media');
            }

            return $this->render('@ViwebMedia/Admin/ajouter.html.twig', array(
                'media' => $media,
                'form' => $form->createView()
            ));
        }
    
         public function mediasAction()
            {
                $em = $this->getDoctrine()->getManager();

                $medias = $em->getRepository('ViwebMediaBundle:Media')->findBy(
                    array(),
                    array(
                        'titre' => 'ASC'
                    )
                );

                return $this->render('@ViwebMedia/Admin/medias.html.twig', array(
                    'medias' => $medias
                ));
            }
    
        public function editAction(Request $request, $media_id)
        {
            $em = $this->getDoctrine()->getManager();

            $media = $em->getRepository('ViwebMediaBundle:Media')->findOneBy(array('id' => $media_id));

            $form = $this->get('form.factory')->create(MediaType::class, $media);
            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
                $em->persist($media);
                $em->flush();

                return $this->redirectToRoute('site_admin_media');
            }

            return $this->render('@ViwebMedia/Admin/edit.html.twig', array(
                'media' => $media,
                'form' => $form->createView()
            ));
        }
    
        public function deleteAction(Request $request, $media_id)
          {
            $em = $this->getDoctrine()->getManager();
            $media = $em->getRepository('ViwebMediaBundle:Media')->find($media_id);
            if (null === $media) {
              throw new NotFoundHttpException("Le media d'id ".$media_id." n'existe pas.");
            }
            // On crée un formulaire vide, qui ne contiendra que le champ CSRF
            // Cela permet de protéger la suppression d'annonce contre cette faille
            $form = $this->get('form.factory')->create();
            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
              $em->remove($media);
              $em->flush();
              $request->getSession()->getFlashBag()->add('info', "Le media a bien été supprimée.");
              return $this->redirectToRoute('site_admin_media');
            }

            return $this->render('@ViwebMedia/Admin/delete.html.twig', array(
              'media' => $media,
              'form'   => $form->createView(),
            ));
          }
    
}
