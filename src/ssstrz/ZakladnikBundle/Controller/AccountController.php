<?php

namespace ssstrz\ZakladnikBundle\Controller;

use ssstrz\ZakladnikBundle\Entity\User;
use ssstrz\ZakladnikBundle\Form\LoginType;
use ssstrz\ZakladnikBundle\Form\Model\Login;
use ssstrz\ZakladnikBundle\Form\Model\Registration;
use ssstrz\ZakladnikBundle\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class AccountController extends Controller
{
    public function loginAction(Request $request)
    {
        $form = $this->createForm(new LoginType(), new Login());
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $user = new User();
            $user->setUsername($form->getData()->getLogin());
            $user->setPassword($form->getData()->getPassword());
            $token = new UsernamePasswordToken($user, $user->getPassword(), $user->getRoles());
            $this->get('security.context')->setToken($token);
            $event = new InteractiveLoginEvent($request, $token);
            $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);

        }
        
        return $this->render(
                'ssstrzZakladnikBundle:Account:login.html.twig',
                array('form' => $form->createView())
        );
    }
    
    public function logoutAction() 
    {
        $this->get('security.context')->setToken(null);
        $this->get('request')->getSession()->invalidate();
    }

    public function registerAction()
    {
        $registration = new Registration();
        $form = $this->createForm(new RegistrationType(), $registration,
                array('action' => $this->generateUrl('ssstrz_zakladnik_register_create'))
        );
        
        return $this->render(
                'ssstrzZakladnikBundle:Account:register.html.twig',
                array('form' => $form->createView())
        );
    }
    public function createAction(Request $request) 
    {
        $form = $this->createForm(new RegistrationType(), new Registration());
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $registration = $form->getData();
            $em->persist($registration->getUser());
            $em->flush();
            
            return $this->redirect($this->generateUrl('ssstrz_zakladnik_login'));
        }
        
        return $this->render(
                'ssstrzZakladnikBundle:Account:register.html.twig',
                array('form' => $form->createView())
        );
    }
}
