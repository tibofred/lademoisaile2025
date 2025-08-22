<?php

namespace Viweb\TemoignageBundle\Controller\Admin;

use Viweb\TemoignageBundle\Entity\Temoignage;
use Viweb\TemoignageBundle\Form\Type\TemoignageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;



class TemoignageController extends Controller
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

        $temoignage = new Temoignage();

        $form = $this->get('form.factory')->create(TemoignageType::class, $temoignage);
        
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($temoignage);
            $em->flush();

            return $this->redirectToRoute('site_admin_temoignages');
        }

        return $this->render('@ViwebTemoignage/Temoignage/Admin/ajouter.html.twig', array(
            'temoignage' => $temoignage,
            'form' => $form->createView()
        ));
    }
    
    

    public function editAction(Request $request, $temoignage_id)
    {
        $this->init();

        $em = $this->getDoctrine()->getManager();

        $temoignage = $em->getRepository('ViwebTemoignageBundle:Temoignage')->findOneBy(array('id' => $temoignage_id));

        $form = $this->get('form.factory')->create(TemoignageType::class, $temoignage);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($temoignage);
            $em->flush();

            return $this->redirectToRoute('site_admin_temoignages');
        }

        return $this->render('@ViwebTemoignage/Temoignage/Admin/edit.html.twig', array(
            'temoignage' => $temoignage,
            'form' => $form->createView()
        ));
    }
    

    public function temoignagesAction()
    {
        $this->init();

            $repository = $this
              ->getDoctrine()
              ->getManager()
              ->getRepository('ViwebTemoignageBundle:Temoignage')
            ;

            $temoignages = $repository->findAll();

        

        return $this->render('@ViwebTemoignage/Temoignage/Admin/temoignages.html.twig', array('temoignages' => $temoignages));
    }
}
