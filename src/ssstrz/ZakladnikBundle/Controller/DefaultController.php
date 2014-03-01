<?php

namespace ssstrz\ZakladnikBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $bookmarks = $em->getRepository('ssstrzZakladnikBundle:Bookmark')->findAll();
        
        return $this->render(
                'ssstrzZakladnikBundle:Default:index.html.twig',
                array('bookmarks' => $bookmarks)
        );
    }
}
