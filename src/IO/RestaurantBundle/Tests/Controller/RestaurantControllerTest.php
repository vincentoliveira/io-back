<?php

namespace IO\RestaurantBundle\Tests\Controller;

use IO\DefaultBundle\Tests\IOTestCase;

class RestaurantControllerTest extends IOTestCase
{
    
    public function setUp()
    {
        parent::setUp();
    }

    
    public function testCompleteScenario()
    {
        $this->deleteUser('TestManager', 'manager@innovorder');
        $this->deleteRestaurant('TestRestaurant');
        $this->deleteRestaurantGroup('TestGroup');
        
        $this->findOrCreateUser('admin', 'admin@innovorder.fr', 'admin', 'ROLE_ADMIN');
        $this->logIn('admin', 'admin');

        // Create a new entry in the database
        $crawler = $this->client->request('GET', '/admin/restaurant/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /admin/restaurant/");
        $crawler = $this->client->click($crawler->selectLink('Nouveau restaurant')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Créer')->form(array(
            'restaurant[name]'  => 'TestRestaurant',
            'restaurant[group][name]'  => 'TestGroup',
            'restaurant[manager][username]' => 'TestManager',
            'restaurant[manager][email]' => 'manager@innovorder.fr',
            'restaurant[manager][plainPassword][first]' => 'test',
            'restaurant[manager][plainPassword][second]' => 'test',
        ));

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        // Check data in the list view
        $crawler = $this->client->request('GET', '/admin/restaurant/');
        $this->assertGreaterThan(0, $crawler->filter('strong:contains("TestGroup")')->count(), 'Missing element strong:contains("TestGroup")');
        $this->assertGreaterThan(0, $crawler->filter('li:contains("TestRestaurant")')->count(), 'Missing element li:contains("TestRestaurant")');

        // Check data in the show view
        $crawler = $this->client->click($crawler->selectLink('TestRestaurant')->link());
        $this->assertGreaterThan(0, $crawler->filter('li:contains("TestManager")')->count(), 'Missing element li:contains("TestManager")');

        // Edit the entity
        $crawler = $this->client->click($crawler->selectLink('Modifier TestRestaurant')->link());
        $form = $crawler->selectButton('Modifier')->form(array(
            'restaurant[name]'  => 'FooRestaurant',
        ));

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('[value="FooRestaurant"]')->count(), 'Missing element [value="FooRestaurant"]');

        // Delete the entity
        $this->client->submit($crawler->selectButton('Supprimer')->form());
        $crawler = $this->client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/FooRestaurant/', $this->client->getResponse()->getContent());
    }
}
