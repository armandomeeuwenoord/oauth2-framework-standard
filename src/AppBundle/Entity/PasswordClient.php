<?php

namespace AppBundle\Entity;

use SpomkyLabs\OAuth2ServerBundle\Plugin\PasswordClientPlugin\Model\PasswordClient as BasePasswordClient;

class PasswordClient extends BasePasswordClient
{
    use ClientBehaviour;

    private $id;

    public function getId()
    {
        return $this->id;
    }
}
