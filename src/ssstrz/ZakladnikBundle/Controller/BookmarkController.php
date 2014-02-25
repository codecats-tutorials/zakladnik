<?php

namespace ssstrz\ZakladnikBundle\Controller;

use ssstrz\ZakladnikBundle\Entity\Bookmark;
use ssstrz\ZakladnikBundle\Form\BookmarkType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BookmarkController extends Controller
{
    public function myAction()
    {
        $user = $this->getUser();
        $bookmarks = $user->getSubscriptions();
        
        return $this->render(
                'ssstrzZakladnikBundle:Bookmark:my.html.twig',
                array('bookmarks' => $bookmarks, 'users' => $bookmarks[0]->getSubscribers())
        );
    }

    public function addAction(Request $request)
    {
        $bookmark = new Bookmark();
        $form = $this->createForm(new BookmarkType(), $bookmark);
        
        $form->handleRequest($request);
        if ($form->isValid()) {
            if ( ! $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
                
                return $this->redirect($this->generateUrl('ssstrz_zakladnik_login'));
            }
            $user = $this->getUser();
            $bookmark->setAuthor($user);
            $bookmark->addSubscriber($user);
            $user->addSubscription($bookmark);
            $em = $this->getDoctrine()->getManager();
            $em->persist($bookmark);
            $em->persist($user);
            $em->flush();
        }
        
        return $this->render(
                'ssstrzZakladnikBundle:Bookmark:add.html.twig',
                array('form' => $form->createView())
        );
    }
    
    public function subscribeAction($id) 
    {
        $user = $this->getUser();
        $bookmark = new Bookmark();
        
    }

    public function removeAction($id)
    {
        
    }

    public function suggestionAction()
    {
    }

}
