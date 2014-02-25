<?php

namespace ssstrz\ZakladnikBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="UserRepository")
 * @UniqueEntity(fields="email", message="This e-mail already taken")
 */
class User implements UserInterface, Serializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=64)
     * @Assert\Length(max="4096")
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive;

    /**
     *
     * @ORM\OneToMany(targetEntity="ssstrz\ZakladnikBundle\Entity\Bookmark", mappedBy="author")
     */
    private $bookmarksCreated;
    
    /**
     * @ORM\ManyToMany(targetEntity="ssstrz\ZakladnikBundle\Entity\Bookmark", inversedBy="subscribers")
     */
    private $subscriptions;

    public function __construct() 
    {
        $this->setIsActive(true);
        $this->bookmarksCreated = new ArrayCollection();
        $this->subscriptions = new ArrayCollection();
    }
    /**
     * Get id
     *
     * @return integer 
     */ 
   public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    public function eraseCredentials() {
        
    }

    public function getRoles() {
        return array('ROLE_USER');
    }

    public function getSalt() {
        return null;
    }

    public function serialize() {
        return serialize(array(
            $this->getId(),
            $this->getPassword(),
            $this->getUsername()
        ));
    }

    public function unserialize($serialized) {
        list(
                $this->id,
                $this->password,
                $this->username
        ) = unserialize($serialized);
    }


    /**
     * Add bookmarksCreated
     *
     * @param \ssstrz\ZakladnikBundle\Entity\Bookmark $bookmarksCreated
     * @return User
     */
    public function addBookmarksCreated(\ssstrz\ZakladnikBundle\Entity\Bookmark $bookmarksCreated)
    {
        $this->bookmarksCreated[] = $bookmarksCreated;

        return $this;
    }

    /**
     * Remove bookmarksCreated
     *
     * @param \ssstrz\ZakladnikBundle\Entity\Bookmark $bookmarksCreated
     */
    public function removeBookmarksCreated(\ssstrz\ZakladnikBundle\Entity\Bookmark $bookmarksCreated)
    {
        $this->bookmarksCreated->removeElement($bookmarksCreated);
    }

    /**
     * Get bookmarksCreated
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBookmarksCreated()
    {
        return $this->bookmarksCreated;
    }

    /**
     * Add subscriptions
     *
     * @param \ssstrz\ZakladnikBundle\Entity\Bookmark $subscriptions
     * @return User
     */
    public function addSubscription(\ssstrz\ZakladnikBundle\Entity\Bookmark $subscriptions)
    {
        $this->subscriptions[] = $subscriptions;

        return $this;
    }

    /**
     * Remove subscriptions
     *
     * @param \ssstrz\ZakladnikBundle\Entity\Bookmark $subscriptions
     */
    public function removeSubscription(\ssstrz\ZakladnikBundle\Entity\Bookmark $subscriptions)
    {
        $this->subscriptions->removeElement($subscriptions);
    }

    /**
     * Get subscriptions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubscriptions()
    {
        return $this->subscriptions;
    }
}
