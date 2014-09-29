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
     * @var UserIdentity
     *
     * @ORM\ManyToOne(targetEntity="IO\UserBundle\Entity\UserWallet")
     * @ORM\JoinColumn(name="wallet_id", referencedColumnName="id", nullable=true)
     */
    private $wallet;
    
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
     * @param \IO\UserBundle\Entity\UserWallet $wallet
     * @return User
     */
    public function setWallet(\IO\UserBundle\Entity\UserWallet $wallet = null)
    {
        $this->wallet = $wallet;
    
        return $this;
    }

    /**
     * Get wallet
     *
     * @return \IO\UserBundle\Entity\UserWallet 
     */
    public function getWallet()
    {
        return $this->wallet;
    }
}