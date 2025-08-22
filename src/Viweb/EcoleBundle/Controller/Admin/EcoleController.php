<?php

namespace Viweb\EcoleBundle\Controller\Admin;

use Viweb\EcoleBundle\Entity\Ecole;
use Viweb\EcoleBundle\Form\Type\EcoleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;




class EcoleController extends Controller
{

    public function init()
    {
        $user = $this->getUser();
        $roles = $user->getRoles();
        $site_url = $this->getParameter('site_url');

        if (!in_array("ROLE_ADMIN", $roles)) {
            ?><script>document.location.href="<?php echo $site_url.'/admin/';?>"</script><?php
            exit();
        }   
        return; 
    }
    
    public function indexAction()
    {
        $this->init();
        return new Response("ADMIN TODO");
    }
    
    

    public function ajouterAction(Request $request)
    {
        $this->init();
        $em = $this->getDoctrine()->getManager();

        $ecole = new Ecole();

        $form = $this->get('form.factory')->create(EcoleType::class, $ecole);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($ecole);
            $em->flush();

            return $this->redirectToRoute('site_admin_ecoles');
        }

        return $this->render('@ViwebEcole/Ecole/Admin/ajouter.html.twig', array(
            'ecole' => $ecole,
            'form' => $form->createView()
        ));
    }
    
    

    public function editAction(Request $request, $ecole_id)
    {
        $this->init();
        $em = $this->getDoctrine()->getManager();

        $ecole = $em->getRepository('ViwebEcoleBundle:Ecole')->findOneBy(array('id' => $ecole_id));

        $form = $this->get('form.factory')->create(EcoleType::class, $ecole);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($ecole);
            $em->flush();

            return $this->redirectToRoute('site_admin_ecoles');
        }

        return $this->render('@ViwebEcole/Ecole/Admin/edit.html.twig', array(
            'ecole' => $ecole,
            'form' => $form->createView()
        ));
    }
    

    public function ecolesAction()
    {
        $this->init();
        $em = $this->getDoctrine()->getManager();

        $ecoles = $em->getRepository('ViwebEcoleBundle:Ecole')->findBy(
            array(),
            array(
                'nom' => 'ASC'
            )
        );

        return $this->render('@ViwebEcole/Ecole/Admin/ecoles.html.twig', array('ecoles' => $ecoles));
    }
    
    
     public function deleteAction(Request $request, $ecole_id)
          {
        $this->init();
            $em = $this->getDoctrine()->getManager();
            $ecole = $em->getRepository('ViwebEcoleBundle:Ecole')->find($ecole_id);
            if (null === $ecole) {
              throw new NotFoundHttpException("L'école d'id ".$ecole_id." n'existe pas.");
            }
            // On crée un formulaire vide, qui ne contiendra que le champ CSRF
            // Cela permet de protéger la suppression d'annonce contre cette faille
            $form = $this->get('form.factory')->create();
            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
              $em->remove($ecole);
              $em->flush();
              $request->getSession()->getFlashBag()->add('info', "L'école a bien été supprimée.");
              return $this->redirectToRoute('site_admin_ecoles');
            }

            return $this->render('@ViwebEcole/Ecole/Admin/delete.html.twig', array(
              'ecole' => $ecole,
              'form'   => $form->createView(),
            ));
          }
    
    
}
