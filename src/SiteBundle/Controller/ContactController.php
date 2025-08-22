<?php

namespace SiteBundle\Controller;

use SiteBundle\Entity\Message;
use SiteBundle\Form\Type\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    public function indexAction(Request $request)
    {
        $message = new Message();

        $form = $this->get('form.factory')->create(ContactType::class, $message);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            $message_to_admin = \Swift_Message::newInstance()
                ->setSubject('Vous avez reçu un nouveau message')
                ->setFrom($this->container->getParameter('mailer_user'))
                ->setTo($this->container->getParameter('mailer_user'))
                ->setBody(
                    $this->renderView(
                        '@Site/Contact/Email/confirmation_admin.html.twig',
                        array(
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
                        '@Site/Contact/Email/confirmation_client.html.twig',
                        array(
                            'message' => $message
                        )
                    ),
                    'text/html'
                );

            $this->get('mailer')->send($message_to_admin);
            $this->get('mailer')->send($message_to_client);

            return $this->redirectToRoute('site_contact_confirmation');
        }

        return $this->render('@Site/Contact/index.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function confirmationAction()
    {
        return $this->render('@Site/Contact/confirmation.html.twig', array());
    }
}
