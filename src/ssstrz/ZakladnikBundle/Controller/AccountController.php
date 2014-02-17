<?php

namespace ssstrz\ZakladnikBundle\Controller;

use ssstrz\ZakladnikBundle\Form\Model\Registration;
use ssstrz\ZakladnikBundle\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccountController extends Controller
{
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
    public function createAction() 
    {
        
    }
}
