<?php

namespace Viweb\EcoleBundle\Controller\Admin;

use Viweb\EcoleBundle\Entity\Commission;
use Viweb\EcoleBundle\Form\Type\CommissionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class CommissionController extends Controller
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

        $commission = new Commission();

        $form = $this->get('form.factory')->create(CommissionType::class, $commission);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($commission);
            $em->flush();

            return $this->redirectToRoute('site_admin_commissions');
        }

        return $this->render('@ViwebEcole/Commission/Admin/ajouter.html.twig', array(
            'commission' => $commission,
            'form' => $form->createView()
        ));
    }

    public function pageAction(Request $request, $region_id, $region_slug)
    {
        $this->init();
        $em = $this->getDoctrine()->getManager();

        $region = $em->getRepository('ViwebBundle:Region')->findOneBy(array('id' => $region_id));

        $form = $this->get('form.factory')->create(RegionType::class, $region);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($region);
            $em->flush();

            return $this->redirectToRoute('site_admin_pages');
        }

        return $this->render('ViwebEcoleBundle:Admin:region.html.twig', array(
            'page' => $page,
            'form' => $form->createView()
        ));
    }

    public function commissionsAction()
    {
        $this->init();
        $em = $this->getDoctrine()->getManager();

        $commissions = $em->getRepository('ViwebEcoleBundle:Commission')->findBy(
            array(),
            array(
                'id' => 'ASC',
                'nom' => 'ASC'
            )
        );

        return $this->render('@ViwebEcole/Commission/Admin/commissions.html.twig', array('commissions' => $commissions));
    }
    
    
     public function editAction(Request $request, $commission_id)
    {
        $this->init();
        $em = $this->getDoctrine()->getManager();

        $commission = $em->getRepository('ViwebEcoleBundle:Commission')->findOneBy(array('id' => $commission_id));

        $form = $this->get('form.factory')->create(CommissionType::class, $commission);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($commission);
            $em->flush();

            return $this->redirectToRoute('site_admin_commissions');
        }

        return $this->render('@ViwebEcole/Commission/Admin/edit.html.twig', array(
            'commission' => $commission,
            'form' => $form->createView()
        ));
    }
    
    
     public function deleteAction(Request $request, $commission_id)
          {
        $this->init();
            $em = $this->getDoctrine()->getManager();
            $commission = $em->getRepository('ViwebEcoleBundle:Commission')->find($commission_id);
            if (null === $commission) {
              throw new NotFoundHttpException("La commission d'id ".$commission_id." n'existe pas.");
            }
            // On crée un formulaire vide, qui ne contiendra que le champ CSRF
            // Cela permet de protéger la suppression d'annonce contre cette faille
            $form = $this->get('form.factory')->create();
            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
              $em->remove($commission);
              $em->flush();
              $request->getSession()->getFlashBag()->add('info', "La commission a bien été supprimée.");
              return $this->redirectToRoute('site_admin_commissions');
            }

            return $this->render('@ViwebEcole/Commission/Admin/delete.html.twig', array(
              'commission' => $commission,
              'form'   => $form->createView(),
            ));
          }
    
    
}
