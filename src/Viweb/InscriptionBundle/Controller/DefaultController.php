<?php

namespace Viweb\InscriptionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Viweb\InscriptionBundle\Entity\Inscription;
use Viweb\InscriptionBundle\Form\InscriptionAdminType;
use Viweb\InscriptionBundle\Form\InscriptionType;


class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        
        
        $inscription = new Inscription();
        $form = $this->get('form.factory')->create(InscriptionType::class, $inscription);


        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            
            /*$arr_red = ['ecole-secondaire-poly-jeunesse', 'ecole-secondaire-de-gracefield', 'ecole-secondaire-des-trois-saisons'];
            if(in_array($inscription->getNomEcole(),$arr_red)) {
                ?>
                <script>document.location.href="https://lademoisaile.ca/inscrire-votre-ecole";</script>
                <?php
                exit();
            }*/

            $em = $this->getDoctrine()->getManager();
            $em->persist($inscription);
            
            
            $ecole = $em->getRepository('ViwebEcoleBundle:Ecole')->findOneBy(array('slug' => $inscription->getNomEcole()));
            
            $ecoleName = $ecole->getNom();
            
            $respCourriel = $ecole->getEmail();
            //$respCourriel = "hicham@viweb.ca";
            
            $em->flush();
            
            $request->getSession()->getFlashBag()->add('notice', 'Inscription réussi.');
            
            

            $message_to_admin = \Swift_Message::newInstance()
                ->setSubject('Nouveau - Inscrivez votre école')
                ->setFrom($this->container->getParameter('mailer_user'))
                ->setTo($respCourriel)
                ->setBody(
                    $this->renderView(
                        '@ViwebInscription/Inscription/Email/confirmation_admin.html.twig',
                        array(
                            'inscription' => $inscription,
                            'ecoleName' => $ecoleName,
                        )
                    ),
                    'text/html'
                );
            
            
             $message_to_client = \Swift_Message::newInstance()
                ->setSubject('Confirmation - Inscrivez votre école')
                ->setFrom($this->container->getParameter('mailer_user'))
                ->setTo($inscription->getCourriel())
                ->setBody(
                    $this->renderView(
                        '@ViwebInscription/Inscription/Email/confirmation_client.html.twig',
                        array(
                            'inscription' => $inscription
                        )
                    ),
                    'text/html'
                );

                            
            $this->get('mailer')->send($message_to_admin);
            $this->get('mailer')->send($message_to_client);
            
            /*return $this->render('@ViwebInscription/Inscription/confirmation.html.twig', array(
                    'inscription' => $inscription
                ));*/
            return $this->redirectToRoute('viweb_inscription_merci');    

            
        }
        
            return $this->render('@ViwebInscription/Inscription/index.html.twig', array(
                    'form' => $form->createView()
                ));


    }

   
        public function confirmationAction()
            {
                return $this->render('@ViwebBase/Contact/inscription.html.twig', array());
            }

    public function merciAction()
            {
                return $this->render('@ViwebInscription/Inscription/merci.html.twig');
            }
}
