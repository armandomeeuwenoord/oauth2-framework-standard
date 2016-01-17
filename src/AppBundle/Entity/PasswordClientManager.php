<?php

namespace AppBundle\Entity;

use SpomkyLabs\OAuth2ServerBundle\Plugin\PasswordClientPlugin\Model\PasswordClientManager as BaseManager;

class PasswordClientManager extends BaseManager
{
    /**
     * {@inheritdoc}
     */
    public function createClient()
    {
        $client = parent::createClient();
        $client->setAllowedGrantTypes([
            'token',
            'code',
            'authorization_code',
            'password',
            'client_credentials',
            'refresh_token',
        ]);
        return $client;
    }
}
