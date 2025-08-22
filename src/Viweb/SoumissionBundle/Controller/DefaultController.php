<?php

namespace Viweb\SoumissionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Viweb\SoumissionBundle\Entity\Soumission;
use Viweb\SoumissionBundle\Form\SoumissionAdminType;
use Viweb\SoumissionBundle\Form\SoumissionType;


class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        
        
        $soumission = new Soumission();
        $form = $this->get('form.factory')->create(SoumissionType::class, $soumission);


        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($soumission);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Soumission réussi.');

            $message_to_admin = \Swift_Message::newInstance()
                ->setSubject('Nouveau - Inscrivez votre école')
                ->setFrom($this->container->getParameter('mailer_user'))
                ->setTo('info@lademoisaile.ca')
                ->setBody(
                    $this->renderView(
                        '@ViwebSoumission/Soumission/Email/confirmation_admin.html.twig',
                        array(
                            'soumission' => $soumission
                        )
                    ),
                    'text/html'
                );
            
            
             $message_to_client = \Swift_Message::newInstance()
                ->setSubject('Confirmation - Inscrivez votre école')
                ->setFrom($this->container->getParameter('mailer_user'))
                ->setTo($soumission->getCourriel())
                ->setBody(
                    $this->renderView(
                        '@ViwebSoumission/Soumission/Email/confirmation_client.html.twig',
                        array(
                            'soumission' => $soumission
                        )
                    ),
                    'text/html'
                );

                            
            $this->get('mailer')->send($message_to_admin);
            $this->get('mailer')->send($message_to_client);
            
            /*return $this->render('@ViwebSoumission/Soumission/confirmation.html.twig', array(
                    'soumission' => $soumission
                ));*/
            return $this->redirectToRoute('viweb_soumission_merci');    

            
        }
        
            return $this->render('@ViwebSoumission/Soumission/index.html.twig', array(
                    'form' => $form->createView()
                ));


    }

   
        public function confirmationAction()
            {
                return $this->render('@ViwebBase/Contact/soumission.html.twig', array());
            }

    public function merciAction()
            {
                return $this->render('@ViwebSoumission/Soumission/merci.html.twig');
            }
}
