<?php

namespace Viweb\EcoleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


use Viweb\EcoleBundle\Entity\MessageEcole;
use Viweb\EcoleBundle\Form\Type\MessageEcoleType;




class EcoleController extends Controller
{
    public function participantesAction()
    {
        $em = $this->getDoctrine()->getManager();
        // Pour récupérer une seule annonce, on utilise la méthode find($id)
        $ecoles = $em->getRepository('ViwebEcoleBundle:Ecole')->findAll(array('nom' => 'ASC'));
        // $advert est donc une instance de OC\PlatformBundle\Entity\Advert
        // ou null si l'id $id n'existe pas, d'où ce if :

        
        return $this->render('ViwebEcoleBundle:Ecole:ecoles-participantes.html.twig', array(
            'ecoles' => $ecoles,
        ));
    }
    
    
    public function singleAction($slug)
    {
        
        $em = $this->getDoctrine()->getManager();

        $ecole = $em->getRepository('ViwebEcoleBundle:Ecole')->findbySlug($slug);
        
        
        $articlesRepository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ViwebArticleBundle:Article');
        
        
        $articles = $articlesRepository->findAllbyEcole($ecole[0]->getId());

        return $this->render('ViwebEcoleBundle:Ecole:single.html.twig', array(
            'ecole' => $ecole[0],
            'articles' => $articles,
        ));;

        
        
    }
    
    public function articlescategorieAction(Request $request, $slug, $categorie_id)
    {
        
        $em = $this->getDoctrine()->getManager();

        $ecole = $em->getRepository('ViwebEcoleBundle:Ecole')->findbySlug($slug);
        
        
        $articlesRepository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ViwebArticleBundle:Article');
        
        
        $articles = $articlesRepository->findAllbyEcoleCategorie($categorie_id);

        return $this->render('ViwebEcoleBundle:Ecole:articles-categories.html.twig', array(
            'ecole' => $ecole[0],
            'articles' => $articles,
        ));;

        
        
    }
    
    
    public function contactAction($slug, Request $request)
    {
        
        $repo = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ViwebEcoleBundle:Ecole');
        
        $ecole = $repo->findOneBySlug($slug);
         
        $emailResponsable = $ecole->getEmail();
    
       $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ViwebUserBundle:User');

        
       $message = new MessageEcole();
        
        $form = $this->get('form.factory')->create(MessageEcoleType::class, $message);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            $message_to_admin = \Swift_Message::newInstance()
                ->setSubject('Vous avez reçu un nouveau message de La deMOIs aile')
                ->setFrom($this->container->getParameter('mailer_user'))
                ->setTo($emailResponsable)
                ->setBody(
                    $this->renderView(
                        '@ViwebEcole/Ecole/Email/confirmation_admin.html.twig',
                        array(
                            'ecole' => $ecole,
                            'message' => $message
                        )
                    ),
                    'text/html'
                );
        
        

            
            $message_to_client = \Swift_Message::newInstance()
                ->setSubject('Confirmation de contact')
                ->setFrom($this->container->getParameter('mailer_user'))
                ->setTo($message->getCourriel())
                ->setBody(
                    $this->renderView(
                        '@ViwebEcole/Ecole/Email/confirmation_client.html.twig',
                        array(
                            'ecole' => $ecole,
                            'message' => $message
                        )
                    ),
                    'text/html'
                );

            $this->get('mailer')->send($message_to_admin);
            $this->get('mailer')->send($message_to_client);
            
            
            return $this->render('ViwebEcoleBundle:Ecole:confirmation.html.twig', array(
                    'ecole' => $ecole,
                    'message' => $message
                ));

        }
         

        return $this->render('ViwebEcoleBundle:Ecole:contact.html.twig', array(
            'ecole' => $ecole,
            'form' => $form->createView()
           
        ));

        
        
    }
    
}