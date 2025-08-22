<?php

namespace Viweb\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Viweb\BaseBundle\Entity\Message;
use Viweb\BaseBundle\Form\Type\ContactType;

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
                ->setTo('info@lademoisaile.ca')
                ->setBody(
                    $this->renderView(
                        '@ViwebBase/Contact/Email/confirmation_admin.html.twig',
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
                        '@ViwebBase/Contact/Email/confirmation_client.html.twig',
                        array(
                            'message' => $message
                        )
                    ),
                    'text/html'
                );

            $this->get('mailer')->send($message_to_admin);
            $this->get('mailer')->send($message_to_client);
            
            
            return $this->render('@ViwebBase/Contact/confirmation.html.twig', array(
                    'message' => $message
                ));


        }

        return $this->render('@ViwebBase/Contact/index.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function confirmationAction()
    {
        return $this->render('@ViwebBase/Contact/confirmation.html.twig', array());
    }
}
