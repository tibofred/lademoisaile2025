<?php

namespace SiteBundle\Controller;

use SiteBundle\Entity\Partenaire;
use SiteBundle\Form\Type\PartenaireType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Viweb\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{
    public function indexAction($page_slug)
    {
        $em = $this->getDoctrine()->getManager();

        $parent_menu = $em->getRepository('SiteBundle:Page')->findBy(array('parent' => null), array('ordre' => 'ASC'));
        $page = $em->getRepository('SiteBundle:Page')->findOneBy(array('slug' => $page_slug));

        if ($page == null) {
            return new Response(
                $this->renderView(':errors:404.html.twig', array(
                    'parent_menu' => $parent_menu,
                )),
                404  // return code
            );
        }

        return $this->render('SiteBundle:Page:index.html.twig', array(
            'parent_menu' => $parent_menu,
            'page' => $page,
        ));
    }
    
    
     public function quiAction()
    {
        $em = $this->getDoctrine()->getManager();

        $marie = $em->getRepository('ViwebUserBundle:User')->findById(4);
        $mathieu = $em->getRepository('ViwebUserBundle:User')->findById(3);
        $page = $em->getRepository('SiteBundle:Page')->findById(4);
         
         return $this->render('SiteBundle:Page:qui.html.twig', array(
            'marie' => $marie[0],
             'mathieu' => $mathieu[0],
             'page' => $page[0],
        ));
    }
    
    
    public function aproposAction()
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $page = $em->getRepository('SiteBundle:Page')->findOneBy(array('slug' => 'a-propos'));
        
        return $this->render('SiteBundle:Page:apropos.html.twig', array(
        
                'page' => $page,
        ));
        
    }
    
    public function wserieAction()
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $page = $em->getRepository('SiteBundle:Page')->findOneBy(array('slug' => 'wserie'));
        
        return $this->render('SiteBundle:Page:webserie.html.twig');
        
    }
    
    public function inscriptionAction()
    {
        return $this->render('SiteBundle:Page:inscription.html.twig');
    }
    
    public function journeefemmeAction()
    {
        return $this->render('SiteBundle:Page:journeefemme.html.twig');
    }
    
    public function lettreaineesAction()
    {
        return $this->render('SiteBundle:Page:lettreainees.html.twig');
    }
    
    public function lettreblogueusesAction()
    {
        return $this->render('SiteBundle:Page:lettreblogueuses.html.twig'); 
    }


    
    public function capsuleAction()
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $page = $em->getRepository('SiteBundle:Page')->findOneBy(array('slug' => 'capsule-video'));
        
        return $this->render('SiteBundle:Page:capsule.html.twig', array(
        
                'page' => $page,
        ));
        
    }

    
    public function bookzineAction()
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $page = $em->getRepository('SiteBundle:Page')->findOneBy(array('slug' => 'bookzine'));
        
        return $this->render('SiteBundle:Page:bookzine.html.twig', array(
        
                'page' => $page,
        ));
        
    }
    
    
    
    public function inscriptionenligneAction()
    {
        return $this->render('SiteBundle:Page:inscription.html.twig');
    }
    
    
    
    public function rapportAction()
    {
        return $this->render('SiteBundle:Page:rapport.html.twig');
    }
    
    
    public function partenairesAction(Request $request)
    {
        
        $partenaire = new Partenaire();

        $form = $this->get('form.factory')->create(PartenaireType::class, $partenaire);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($partenaire);
            $em->flush();

            $message_to_admin = \Swift_Message::newInstance()
                ->setSubject('Vous avez reçu une nouvelle demande de partenariat')
                ->setFrom($this->container->getParameter('mailer_user'))
                ->setTo($this->container->getParameter('mailer_user'))
                //->setTo('hicham@viweb.ca')
                ->setBody(
                    $this->renderView(
                        '@Site/Page/Email/confirmation_admin_part.html.twig',
                        array(
                            'partenaire' => $partenaire
                        )
                    ),
                    'text/html'
                );

            $message_to_client = \Swift_Message::newInstance()
                ->setSubject('Confirmation de contact')
                ->setFrom($this->container->getParameter('mailer_user'))
                ->setTo($partenaire->getCourriel())
                ->setBody(
                    $this->renderView(
                        '@Site/Page/Email/confirmation_client_part.html.twig',
                        array(
                            'partenaire' => $partenaire
                        )
                    ),
                    'text/html'
                );

            $this->get('mailer')->send($message_to_admin);
            $this->get('mailer')->send($message_to_client);

            return $this->redirectToRoute('site_partenaires_confirmation');
        }

        return $this->render('SiteBundle:Page:partenaires.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    public function partenairesconfirmAction()
    {
        

        return $this->render('SiteBundle:Page:partenaires-confirm.html.twig', array(
        ));
    }
}
