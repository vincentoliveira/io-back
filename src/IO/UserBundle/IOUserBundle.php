<?php

namespace IO\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class IOUserBundle extends Bundle
{
    /*
     * {@inheritDoc}
     */
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
