<?php

namespace SiteBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContactController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $messages = $em->getRepository('SiteBundle:Message')->findAll();

        return $this->render('@Site/Contact/Admin/index.html.twig', array(
            'messages' => $messages
        ));
    }

    public function messageAction($message_id)
    {
        $em = $this->getDoctrine()->getManager();

        $message = $em->getRepository('SiteBundle:Message')->find($message_id);

        if($message === null)
            return $this->redirectToRoute('site_admin_messages');

        return $this->render('@Site/Contact/Admin/message.html.twig', array(
            'message' => $message
        ));
    }
}
