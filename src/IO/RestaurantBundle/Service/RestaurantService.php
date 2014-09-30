<?php

namespace IO\RestaurantBundle\Service;

use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation\Inject;
use IO\RestaurantBundle\Entity\Restaurant;

/**
 * Description of RestaurantService
 *
 * @author vincent
 * @Service("io.media_service")
 */
class RestaurantService
{

    /**
     * Entity Manager
     * 
     * @Inject("doctrine.orm.entity_manager")
     * @var \Doctrine\ORM\EntityManager
     */
    public $em;

    /**
     * Create default value for restaurant
     * 
     * @param Restaurant $restaurant
     * @return Restaurant
     */
    public function createDefaultValue(Restaurant $restaurant)
    {
        return $restaurant;
    }

}
