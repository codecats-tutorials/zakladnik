<?php
namespace ssstrz\ZakladnikBundle\Form\Model;

use ssstrz\ZakladnikBundle\Entity\User;

use Symfony\Component\Validator\Constraint as Assert;

class Registration 
{
    /**
     * @Assert\Type(type=User")
     * @Assert\Valid()
     */
    protected $user;
    
    /**
     *
     * @Assert\NotBlank()
     * @Assert\True() 
     */
    protected $termsAccepted;
    
    public function setUser($user) 
    {
        $this->user = $user;
    }
    
    public function getUser() 
    {
        return $this->user;
    }
    
    public function setTermsAccepted($terms) 
    {
        $this->termsAccepted = (boolean) $terms;
    }
    
    public function getTermsAccepted() 
    {
        return $this->termsAccepted;
    }
}
