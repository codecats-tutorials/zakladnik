<?php

namespace ssstrz\ZakladnikBundle\Controller;

use ssstrz\ZakladnikBundle\Entity\Bookmark;
use ssstrz\ZakladnikBundle\Entity\BookmarkRepository;
use ssstrz\ZakladnikBundle\Form\BookmarkType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BookmarkController extends Controller
{
    public function myAction()
    {
        if ( ! $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Zaloguj się najpierw proszę'
            );
            return $this->redirect($this->generateUrl('login'));
        }
        $user = $this->getUser();
        $bookmarks = $user->getSubscriptions();
        
        return $this->render(
                'ssstrzZakladnikBundle:Bookmark:my.html.twig',
                array('bookmarks' => $bookmarks)
        );
    }

    public function addAction(Request $request)
    {
        $bookmark = new Bookmark();
        $form = $this->createForm(new BookmarkType(), $bookmark);
        
        $form->handleRequest($request);
        if ($form->isValid()) {
            if ( ! $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
                
                return $this->redirect($this->generateUrl('login'));
            }
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $bookmarkRespository = $em->getRepository('ssstrzZakladnikBundle:Bookmark');
            $res = $bookmarkRespository->findOneBy(
                    array('url' =>$bookmark->getUrl())
            );
            if ( ! empty($res)) {
                $bookmark = $res;
            } else {
                $bookmark->setAuthor($user);
            }
            
            $bookmark->addSubscriber($user);
            $user->addSubscription($bookmark);
            
            $em->persist($bookmark);
            $em->persist($user);
            $em->flush();
            
            return $this->redirect($this->generateUrl('ssstrz_zakladnik_my'));
        }
        
        return $this->render(
                'ssstrzZakladnikBundle:Bookmark:add.html.twig',
                array('form' => $form->createView())
        );
    }
    
    public function subscribeAction($id) 
    {
        if ( ! $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
                
            return $this->redirect($this->generateUrl('login'));
        }
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $subscrbtions = $user->getSubscriptions();
        foreach ($subscrbtions as $subscribe) {
            if ($subscribe->getId() == $id) {
                $this->get('session')->getFlashBag()->add(
                        'notice',
                        'Aktualnie subskrybujesz zakładkę ' . $subscribe->getTitle()
                );
                
                return $this->redirect($this->generateUrl('ssstrz_zakladnik_my'));
            }
        }
        $bookmarkRespository = $em->getRepository('ssstrzZakladnikBundle:Bookmark');
        $bookmark = $bookmarkRespository->find($id);

        $bookmark->addSubscriber($user);
        $user->addSubscription($bookmark);

        $em->persist($bookmark);
        $em->persist($user);
        $em->flush();

        return $this->redirect($this->generateUrl('ssstrz_zakladnik_my'));
    }

    public function removeAction($id)
    {
        if ( ! $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
                
            return $this->redirect($this->generateUrl('login'));
        }
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $bookmarkRespository = $em->getRepository('ssstrzZakladnikBundle:Bookmark');
        $bookmark = $bookmarkRespository->find($id);

        $bookmark->removeSubscriber($user);
        $user->removeSubscription($bookmark);

        $em->persist($bookmark);
        $em->persist($user);
        $em->flush();

        return $this->redirect($this->generateUrl('ssstrz_zakladnik_my'));
    }

    public function suggestionAction()
    {
        if ( ! $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            
            return $this->redirect($this->generateUrl('login'));
        }
        $em = $this->getDoctrine()->getManager();
        $bookmarkRespository = $em->getRepository('ssstrzZakladnikBundle:Bookmark');
        $result = $bookmarkRespository->getSuggestionFor($this->getUser());
        
        return $this->render(
                'ssstrzZakladnikBundle:Bookmark:suggestion.html.twig',
                array('result' => $result)
        );
    }
}
