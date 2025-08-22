<?php

namespace Viweb\MailchimpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Viweb\MailchimpBundle\Entity\Mailchimp;
use Viweb\MailchimpBundle\Form\Type\MailchimpFooterType;
use Viweb\MailchimpBundle\Form\Type\MailchimpType;
use Welp\MailchimpBundle\Event\SubscriberEvent;
use Welp\MailchimpBundle\Subscriber\Subscriber;

class DefaultController extends Controller
{
    public function renderMailchimpFooterAction(Request $request){
        $inscription = new Mailchimp();

        $form = $this->get('form.factory')->create(MailchimpFooterType::class, $inscription);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $data = $request->request->get('form');


            $subscriber = new Subscriber($data['email'], [
                'FIRSTNAME' => $data['email'],
            ], [
                'language' => 'fr'
            ]);

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

        return $this->render('SiteBundle:Default:mailchimp.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    public function infolettreAction(Request $request)
    {
        $inscription = new Mailchimp();

        $form = $this->get('form.factory')->create(MailchimpType::class, $inscription);


        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $data = $request->request->get('form');
            $subscriber = new Subscriber($data['email']);

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


        return $this->render('@ViwebMailchimp/infolettre.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function merciAction()
    {
        return $this->render('@ViwebMailchimp/merci.html.twig', array());
    }
}
