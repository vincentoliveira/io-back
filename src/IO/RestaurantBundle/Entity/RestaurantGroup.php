<?php

namespace IO\RestaurantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Restaurant Groupe
 *
 * @ORM\Table(name="restaurant_group")
 * @ORM\Entity()
 */
class RestaurantGroup
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
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="IO\RestaurantBundle\Entity\Restaurant", mappedBy="group", cascade={"remove", "persist"})
     */
    private $restaurants;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\ManyToMany(targetEntity="IO\UserBundle\Entity\User")
     * @ORM\JoinTable(name="users_restaurant_groups",
     *      joinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", unique=true)}
     *      )
     **/
    private $managers;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->restaurants = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return RestaurantGroup
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
     * Add restaurants
     *
     * @param \IO\RestaurantBundle\Entity\Restaurant $restaurants
     * @return RestaurantGroup
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
     * Add managers
     *
     * @param \IO\UserBundle\Entity\User $managers
     * @return RestaurantGroup
     */
    public function addManager(\IO\UserBundle\Entity\User $managers)
    {
        $this->managers[] = $managers;

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
            return null;
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
