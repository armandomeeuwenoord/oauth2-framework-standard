<?php

namespace AppBundle\Entity;

use SpomkyLabs\OAuth2ServerBundle\Plugin\CorePlugin\Model\ResourceOwnerManagerBehaviour;
use SpomkyLabs\OAuth2ServerBundle\Plugin\UnregisteredClientPlugin\Model\UnregisteredClientManager as Base;

class UnregisteredClientManager extends Base
{
    use ResourceOwnerManagerBehaviour;

    /**
     * {@inheritdoc}
     */
    public function getClient($public_id)
    {
    }

    public function createClient()
    {
        $class = $this->getClass();

        return new $class();
    }
}
