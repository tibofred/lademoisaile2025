<?php

namespace SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Viweb\MailchimpBundle\Entity\Mailchimp;
use Viweb\MailchimpBundle\Form\Type\MailchimpFooterType;
use Welp\MailchimpBundle\Event\SubscriberEvent;
use Welp\MailchimpBundle\Subscriber\Subscriber;

class DefaultController extends Controller
{
    
    
    
    public function indexAction(Request $request)
    {
        $inscription = new Mailchimp();

        $form = $this->get('form.factory')->create(MailchimpFooterType::class, $inscription);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $subscriber = new Subscriber($inscription->getEmail());

            $this->container->get('event_dispatcher')->dispatch(
                SubscriberEvent::EVENT_SUBSCRIBE,
                new SubscriberEvent('21abbd23a1', $subscriber)
            );

            $em = $this->getDoctrine()->getManager();
            // On persiste car Doctrine ne connait pas encore cette objet, on  lui donne en charge
            $em->persist($inscription);
            // On crée l'objet (on met en base de donnée)
            $em->flush();

            // Si tout c'est bien passé on crée le message
            $request->getSession()->getFlashBag()->add('notice', 'Courriel bien enregistré');

            // On renvoi vers la page qui a été créé
            return $this->redirectToRoute('viweb_infolettre_merci');
        }
        
        
        
        
        $articlesRepository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ViwebArticleBundle:Article');
        
        
        $articles = $articlesRepository->findDerniersArticles(12);
        
        
        $useragent = $_SERVER['HTTP_USER_AGENT']; 
        $iPod = stripos($useragent, "iPod"); 
        $iPad = stripos($useragent, "iPad"); 
        $iPhone = stripos($useragent, "iPhone");
        $Android = stripos($useragent, "Android"); 
        $iOS = stripos($useragent, "iOS");
        //-- You can add billion devices 
        
        $device = "desktop";
        if($iPod||$iPad||$iPhone||$Android||$iOS) {
            $device = "mobile";
        }

        return $this->render('SiteBundle:Default:index.html.twig', array(
            'articles' => $articles,
            'form' => $form->createView(),
            'device' => $device,
        ));
    }
    
    
    
    

    public function navPagesAction($page_slug = "")
    {
        $em = $this->getDoctrine()->getManager();
        $parent_menu = $em->getRepository('SiteBundle:Page')->findBy(array('parent' => null), array('ordre' => 'ASC'));

        $page = ($page_slug != "") ? $em->getRepository('SiteBundle:Page')->findOneBy(array('slug' => $page_slug)) : null;

        return $this->render('SiteBundle:Default:nav.html.twig', array(
            'parent_menu' => $parent_menu,
            'page' => $page,
        ));
    }

    public function searchAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $search = $request->query->get('q');
        $blogueuses = $em->getRepository('ViwebBlogueuseBundle:Blogueuse')->getBlogueusesSearch($search);
        
        $articles = $em->getRepository('ViwebArticleBundle:Article')->searchArticles($search);
        
        return $this->render('SiteBundle:Default:searcht.html.twig', array(
            'blogueuses' => $blogueuses,
            'articles' => $articles,
            'search' => $search
        ));
    }
    /*public function searchtAction(Request $request) {
        
        $em = $this->getDoctrine()->getManager();

        $search = $request->query->get('q');
        $blogueuses = $em->getRepository('ViwebBlogueuseBundle:Blogueuse')->getBlogueusesSearch($search);
        
        $articles = $em->getRepository('ViwebArticleBundle:Article')->searchArticles($search);
        
        return $this->render('SiteBundle:Default:searcht.html.twig', array(
            'blogueuses' => $blogueuses,
            'articles' => $articles,
            'search' => $search
        ));
    }*/
}
