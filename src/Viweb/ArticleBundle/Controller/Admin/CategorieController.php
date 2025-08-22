<?php

namespace Viweb\ArticleBundle\Controller\Admin;

use Viweb\ArticleBundle\Entity\Categorie;
use Viweb\ArticleBundle\Form\Type\CategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class CategorieController extends Controller
{
    public function ajouterAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $categorie = new Categorie();

        $form = $this->get('form.factory')->create(CategorieType::class, $categorie);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($categorie);
            $em->flush();

            return $this->redirectToRoute('site_admin_blogueuses');
        }

        return $this->render('@ViwebArticle/Categorie/Admin/ajouter.html.twig', array(
            'categorie' => $categorie,
            'form' => $form->createView()
        ));
    }
}
