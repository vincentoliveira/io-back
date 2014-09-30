<?php

namespace IO\RestaurantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IO\UserBundle\Entity\User;

/**
 * Restaurant
 *
 * @ORM\Table(name="restaurant")
 * @ORM\Entity()
 */
class Restaurant
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=63, nullable=false)
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="IO\RestaurantBundle\Entity\RestaurantGroup", cascade={"persist"})
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $group;
    
    /**
     * @var Address
     *
     * @ORM\ManyToOne(targetEntity="IO\UserBundle\Entity\Address", cascade={"persist"})
     * @ORM\JoinColumn(name="address_id", referencedColumnName="id", nullable=true)
     */
    private $address;
    
    /**
     * @var PhoneNumber
     *
     * @ORM\ManyToOne(targetEntity="IO\UserBundle\Entity\PhoneNumber", cascade={"persist"})
     * @ORM\JoinColumn(name="phone_id", referencedColumnName="id", nullable=true)
     */
    private $phone;

    /**
     * @var UserWallet
     *
     * @ORM\ManyToOne(targetEntity="IO\UserBundle\Entity\MangoPayWallet", cascade={"persist"})
     * @ORM\JoinColumn(name="wallet_id", referencedColumnName="id", nullable=true)
     */
    private $wallet;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\ManyToMany(targetEntity="IO\UserBundle\Entity\User")
     * @ORM\JoinTable(name="users_restaurants",
     *      joinColumns={@ORM\JoinColumn(name="restaurant_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", unique=true)}
     *      )
     **/
    private $managers;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->managers = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Restaurant
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set address
     *
     * @param \IO\UserBundle\Entity\Address $address
     * @return Restaurant
     */
    public function setAddress(\IO\UserBundle\Entity\Address $address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return \IO\UserBundle\Entity\Address 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set phone
     *
     * @param \IO\UserBundle\Entity\PhoneNumber $phone
     * @return Restaurant
     */
    public function setPhone(\IO\UserBundle\Entity\PhoneNumber $phone = null)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return \IO\UserBundle\Entity\PhoneNumber 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set group
     *
     * @param \IO\RestaurantBundle\Entity\RestaurantGroup $group
     * @return Restaurant
     */
    public function setGroup(\IO\RestaurantBundle\Entity\RestaurantGroup $group)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \IO\RestaurantBundle\Entity\RestaurantGroup 
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Set wallet
     *
     * @param \IO\UserBundle\Entity\MangoPayWallet $wallet
     * @return Restaurant
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
     * Add managers
     *
     * @param \IO\UserBundle\Entity\User $manager
     * @return Restaurant
     */
    public function addManager(\IO\UserBundle\Entity\User $manager)
    {
        $this->managers[] = $manager;

        return $this;
    }

    /**
     * Remove managers
     *
     * @param \IO\UserBundle\Entity\User $managers
     */
    public function removeManager(\IO\UserBundle\Entity\User $managers)
    {
        $this->managers->removeElement($managers);
    }

    /**
     * Get managers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getManagers()
    {
        return $this->managers;
    }
    
    /**
     * Get manager
     *
     * @return \IO\UserBundle\Entity\User
     */
    public function getManager()
    {
        if ($this->managers->isEmpty()) {
            return new User();
        }
        
        return $this->managers->first();
    }
    
    /**
     * Set manager
     *
     * @param \IO\UserBundle\Entity\User $managers
     * @return \IO\UserBundle\Entity\User
     */
    public function setManager(\IO\UserBundle\Entity\User $manager)
    {
        $this->managers[] = $manager;

        return $this;
    }
}
