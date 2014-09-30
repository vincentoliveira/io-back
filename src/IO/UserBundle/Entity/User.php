<?php

namespace IO\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User entity (extends fosuser)
 * 
 * @ORM\Entity()
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @var integer $id
     * @access protected
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var UserIdentity
     *
     * @ORM\ManyToOne(targetEntity="IO\UserBundle\Entity\UserIdentity")
     * @ORM\JoinColumn(name="identity_id", referencedColumnName="id", nullable=true)
     */
    private $identity;

    /**
     * @var MangoPayWallet
     *
     * @ORM\ManyToOne(targetEntity="IO\UserBundle\Entity\MangoPayWallet")
     * @ORM\JoinColumn(name="wallet_id", referencedColumnName="id", nullable=true)
     */
    private $wallet;
    
    /**
     * @ORM\ManyToMany(targetEntity="IO\RestaurantBundle\Entity\Restaurant", mappedBy="managers")
     **/
    private $restaurants;
    
    /**
     * @ORM\ManyToMany(targetEntity="IO\RestaurantBundle\Entity\RestaurantGroup", mappedBy="managers")
     **/
    private $restaurantGroups;

    public function __construct() {
     parent::__construct();

     $this->restaurants = new \Doctrine\Common\Collections\ArrayCollection();
        $this->restaurantGroups = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set identity
     *
     * @param \IO\UserBundle\Entity\UserIdentity $identity
     * @return User
     */
    public function setIdentity(\IO\UserBundle\Entity\UserIdentity $identity = null)
    {
        $this->identity = $identity;
    
        return $this;
    }

    /**
     * Get identity
     *
     * @return \IO\UserBundle\Entity\UserIdentity 
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * Set wallet
     *
     * @param \IO\UserBundle\Entity\MangoPayWallet $wallet
     * @return User
     */
    public function setWallet(\IO\UserBundle\Entity\MangoPayWallet $wallet = null)
    {
        $this->wallet = $wallet;
    
        return $this;
    }

    /**
     * Get wallet
     *
     * @return \IO\UserBundle\Entity\MangoPayWallet 
     */
    public function getWallet()
    {
        return $this->wallet;
    }

    /**
     * Add restaurants
     *
     * @param \IO\RestaurantBundle\Entity\Restaurant $restaurants
     * @return User
     */
    public function addRestaurant(\IO\RestaurantBundle\Entity\Restaurant $restaurants)
    {
        $this->restaurants[] = $restaurants;

        return $this;
    }

    /**
     * Remove restaurants
     *
     * @param \IO\RestaurantBundle\Entity\Restaurant $restaurants
     */
    public function removeRestaurant(\IO\RestaurantBundle\Entity\Restaurant $restaurants)
    {
        $this->restaurants->removeElement($restaurants);
    }

    /**
     * Get restaurants
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRestaurants()
    {
        return $this->restaurants;
    }

    /**
     * Add restaurantGroups
     *
     * @param \IO\RestaurantBundle\Entity\RestaurantGroup $restaurantGroups
     * @return User
     */
    public function addRestaurantGroup(\IO\RestaurantBundle\Entity\RestaurantGroup $restaurantGroups)
    {
        $this->restaurantGroups[] = $restaurantGroups;

        return $this;
    }

    /**
     * Remove restaurantGroups
     *
     * @param \IO\RestaurantBundle\Entity\RestaurantGroup $restaurantGroups
     */
    public function removeRestaurantGroup(\IO\RestaurantBundle\Entity\RestaurantGroup $restaurantGroups)
    {
        $this->restaurantGroups->removeElement($restaurantGroups);
    }

    /**
     * Get restaurantGroups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRestaurantGroups()
    {
        return $this->restaurantGroups;
    }
}
