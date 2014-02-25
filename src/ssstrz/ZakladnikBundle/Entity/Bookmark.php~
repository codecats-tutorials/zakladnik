<?php

namespace ssstrz\ZakladnikBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Bookmark
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="BookmarkRepository")
 */
class Bookmark
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     * @Assert\Url
     */
    private $url;

    /**
     * @ORM\ManyToOne(targetEntity="ssstrz\ZakladnikBundle\Entity\User", inversedBy="bookmarksCreated")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     */
    private $author;
    
    /**
     * @ORM\ManyToMany(targetEntity="ssstrz\ZakladnikBundle\Entity\User", mappedBy="subscriptions")
     */
    private $subscribers;

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
     * Set title
     *
     * @param string $title
     * @return Bookmark
     */
    public function setTitle($title)
    {
        $this->title = $title;
       
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Bookmark
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set author
     *
     * @param \ssstrz\ZakladnikBundle\Entity\User $author
     * @return Bookmark
     */
    public function setAuthor(\ssstrz\ZakladnikBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \ssstrz\ZakladnikBundle\Entity\User 
     */
    public function getAuthor()
    {
        return $this->author;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->subscribers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add subscribers
     *
     * @param \ssstrz\ZakladnikBundle\Entity\User $subscribers
     * @return Bookmark
     */
    public function addSubscriber(\ssstrz\ZakladnikBundle\Entity\User $subscribers)
    {
        $this->subscribers[] = $subscribers;

        return $this;
    }

    /**
     * Remove subscribers
     *
     * @param \ssstrz\ZakladnikBundle\Entity\User $subscribers
     */
    public function removeSubscriber(\ssstrz\ZakladnikBundle\Entity\User $subscribers)
    {
        $this->subscribers->removeElement($subscribers);
    }

    /**
     * Get subscribers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubscribers()
    {
        return $this->subscribers;
    }
}
