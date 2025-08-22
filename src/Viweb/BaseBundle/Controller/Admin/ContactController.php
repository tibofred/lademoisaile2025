<?php

namespace Viweb\BaseBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContactController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $messages = $em->getRepository('ViwebBaseBundle:Message')->findAll();

        return $this->render('@ViwebBase/Contact/Admin/index.html.twig', array(
            'messages' => $messages
        ));
    }

    public function messageAction($message_id)
    {
        $em = $this->getDoctrine()->getManager();

        $message = $em->getRepository('ViwebBaseBundle:Message')->find($message_id);

        if($message === null)
            return $this->redirectToRoute('viweb_base_admin_messages');

        return $this->render('@ViwebBase/Contact/Admin/message.html.twig', array(
            'message' => $message
        ));
    }
}
