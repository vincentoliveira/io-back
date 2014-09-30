<?php

namespace IO\DefaultBundle\Tests\Controller;

use IO\DefaultBundle\Tests\IOTestCase;

class DefaultControllerTest extends IOTestCase
{
    
    public function setUp()
    {
        parent::setUp();
    }

    public function testSecuredUnlogged()
    {
        $this->client->request('GET', '/');

        $this->assertFalse($this->client->getResponse()->isSuccessful());
    }

    public function testSecuredLogged()
    {
        $username = 'usertest';
        $password = 'usertest';
        $this->findOrCreateUser($username, null, $password);
        $this->logIn($username, $password);

        $this->client->request('GET', '/');

        $crawler = $this->client->getCrawler();
        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Déconnexion")')->count());
    }

}
