<?php

namespace AppBundle\Entity;

use SpomkyLabs\OAuth2ServerBundle\Plugin\PublicClientPlugin\Model\PublicClientManager as Base;

class PublicClientManager extends Base
{
    /**
     * {@inheritdoc}
     */
    public function createClient()
    {
        $client = parent::createClient();
        $client->setAllowedGrantTypes([
            'token',
            'authorization_code',
            'password',
            'refresh_token',
        ]);
        return $client;
    }
}
