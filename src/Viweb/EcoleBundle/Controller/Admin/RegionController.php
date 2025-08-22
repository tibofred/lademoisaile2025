<?php

namespace Viweb\EcoleBundle\Controller\Admin;

use Viweb\EcoleBundle\Entity\Region;
use Viweb\EcoleBundle\Form\Type\RegionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class RegionController extends Controller
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

        $region = new Region();

        $form = $this->get('form.factory')->create(RegionType::class, $region);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($region);
            $em->flush();

            return $this->redirectToRoute('site_admin_regions');
        }

        return $this->render('@ViwebEcole/Region/Admin/ajouter.html.twig', array(
            'region' => $region,
            'form' => $form->createView()
        ));
    }

    
     public function editAction(Request $request, $region_id)
    {
        $this->init();
        $em = $this->getDoctrine()->getManager();

        $region = $em->getRepository('ViwebEcoleBundle:Region')->findOneBy(array('id' => $region_id));

        $form = $this->get('form.factory')->create(RegionType::class, $region);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($region);
            $em->flush();

            return $this->redirectToRoute('site_admin_regions');
        }

        return $this->render('@ViwebEcole/Region/Admin/edit.html.twig', array(
            'region' => $region,
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

    public function regionsAction()
    {
        $this->init();
        $em = $this->getDoctrine()->getManager();

        $regions = $em->getRepository('ViwebEcoleBundle:Region')->findBy(
            array(),
            array(
                'id' => 'ASC',
                'nom' => 'ASC'
            )
        );

        return $this->render('@ViwebEcole/Region/Admin/regions.html.twig', array('regions' => $regions));
    }
    
    public function deleteAction(Request $request, $region_id)
          {
        $this->init();
            $em = $this->getDoctrine()->getManager();
            $region = $em->getRepository('ViwebEcoleBundle:Region')->find($region_id);
            if (null === $region) {
              throw new NotFoundHttpException("La region d'id ".$region_id." n'existe pas.");
            }
            // On crée un formulaire vide, qui ne contiendra que le champ CSRF
            // Cela permet de protéger la suppression d'annonce contre cette faille
            $form = $this->get('form.factory')->create();
            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
              $em->remove($region);
              $em->flush();
              $request->getSession()->getFlashBag()->add('info', "La région a bien été supprimée.");
              return $this->redirectToRoute('site_admin_regions');
            }

            return $this->render('@ViwebEcole/Region/Admin/delete.html.twig', array(
              'region' => $region,
              'form'   => $form->createView(),
            ));
          }
}
