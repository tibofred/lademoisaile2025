<?php

namespace SiteBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SiteBundle:Default/Admin:index.html.twig');
    }
}
