<?php

namespace ssstrz\ZakladnikBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ssstrzZakladnikBundle:Default:index.html.twig', array('name' => $name));
    }
}
