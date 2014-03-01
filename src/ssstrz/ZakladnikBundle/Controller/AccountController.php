<?php

namespace ssstrz\ZakladnikBundle\Controller;

use ssstrz\ZakladnikBundle\Entity\User;
use ssstrz\ZakladnikBundle\Form\LoginType;
use ssstrz\ZakladnikBundle\Form\Model\Login;
use ssstrz\ZakladnikBundle\Form\Model\Registration;
use ssstrz\ZakladnikBundle\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

class AccountController extends Controller
{
    public function testAction() 
    {
        $user = new User();
        $securityContext = $this->container->get('security.context');
     //   if( $securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED') ){
        $factory = $this->get('security.encoder_factory');
        $encoder = $factory->getEncoder($user);
        $password = $encoder->encodePassword('rayan', $user->getSalt());
        
        return $this->render('ssstrzZakladnikBundle::test.html.twig', 
                array( 'res' => $password)
        );
   //     }    
    }
    public function loginAction(Request $request)
    {
        $form = $this->createForm(new LoginType(), new Login());
        $request = $this->getRequest();
        $session = $request->getSession();
        
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
       
        
        return $this->render(
                'ssstrzZakladnikBundle:Account:login.html.twig',
                array(
                    'form' => $form->createView(),
                    'error'         => $error
                )
        );
    }
    
    public function logoutAction() 
    {
        $this->get('security.context')->setToken(null);
        $this->get('request')->getSession()->invalidate();
        
        return $this->redirect($this->generateUrl('login'));
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
            
            $factory = $this->get('security.encoder_factory');
            $user = $registration->getUser();

            $encoder = $factory->getEncoder($user);
            $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
            $user->setPassword($password);
            
            $em->persist($user);
            $em->flush();
            
            return $this->redirect($this->generateUrl('login'));
        }
        
        return $this->render(
                'ssstrzZakladnikBundle:Account:register.html.twig',
                array('form' => $form->createView())
        );
    }
}
