<?php

namespace IO\UserBundle\Twig;

use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\Tag;
use IO\UserBundle\Enum\CountryEnum;

/**
 * Order TwigExtension
 * 
 * @Service("io.user_twig_extension")
 * @Tag("twig.extension")
 */
class UserTwigExtension extends \Twig_Extension
{

    /**
     * {@inheritDoc}
     */
    public function getGlobals()
    {
        return array();
    }

    /**
     * {@inheritDoc}
     */
    public function getFilters()
    {
        return array(
            'country' => new \Twig_SimpleFilter('country', array($this, 'countryFilter')),
        );
    }

    /**
     * Return country name from country code
     * 
     * @return string
     */
    public function countryFilter($countryCode)
    {
        if (!isset(CountryEnum::$countries[$countryCode])) {
            return $countryCode;
        }
        return CountryEnum::$countries[$countryCode];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'user_twig_extension';
    }

}
