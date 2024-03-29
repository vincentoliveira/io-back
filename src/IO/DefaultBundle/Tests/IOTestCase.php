<?php

namespace IO\DefaultBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use IO\UserBundle\Entity\User;

/**
 * Description of IOTestCase
 */
abstract class IOTestCase extends WebTestCase
{

    /**
     * @var \Symfony\Bundle\FrameworkBundle\Client
     */
    protected $client;

    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    public function setUp()
    {
        parent::setUp();
        
        $this->client = static::createClient(array('environment' => 'test'));
        $this->container = $this->client->getContainer();

        $this->em = $this->container->get('doctrine.orm.entity_manager');

    }

    protected function logIn($username, $password)
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('_submit')->form(array(
            '_username' => $username,
            '_password' => $password,
        ));
        $this->client->submit($form);

        $this->assertTrue($this->client->getResponse()->isRedirect());
    }

    protected function findOrCreateUser($username, $email = null, $password = null, $role = 'ROLE_ADMIN')
    {
        /** @var $userManager \FOS\UserBundle\Doctrine\UserManager */
        $userManager = $this->container->get('fos_user.user_manager');

        $user = $userManager->findUserBy(array('username' => $username));
        if ($user === null) {
            $user = new User();
        }

        $user->setUsername($username);
        $user->setPlainPassword($password ? $password : $username);
        $user->setEmail($email ? $email : ($username . '@innovorder.fr'));
        $user->addRole($role);
        $user->setEnabled(true);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
    
    protected function deleteUser($username, $email = null)
    {
        /** @var $userManager \FOS\UserBundle\Doctrine\UserManager */
        $userManager = $this->container->get('fos_user.user_manager');

        $user = $userManager->findUserBy(array('username' => $username));
        if ($user !== null) {
            $this->em->remove($user);
        }
        
        $user2 = $userManager->findUserBy(array('email' => $email));
        if ($user2 !== null) {
            $this->em->remove($user2);
        }
        
        $this->em->flush();
    }
    
    protected function deleteRestaurant($restaurantName)
    {
        $repository = $this->em->getRepository('IORestaurantBundle:Restaurant');

        $group = $repository->findOneByName($restaurantName);
        if ($group !== null) {
            $this->em->remove($group);
        }
        
        $this->em->flush();
    }
    
    protected function deleteRestaurantGroup($groupName)
    {
        $repository = $this->em->getRepository('IORestaurantBundle:RestaurantGroup');

        $group = $repository->findOneByName($groupName);
        if ($group !== null) {
            $this->em->remove($group);
        }
        
        $this->em->flush();
    }

}
