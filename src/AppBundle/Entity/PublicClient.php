<?php

namespace AppBundle\Entity;

use SpomkyLabs\OAuth2ServerBundle\Plugin\PublicClientPlugin\Model\PublicClient as BasePublicClient;

class PublicClient extends BasePublicClient
{
    use ClientBehaviour;

    private $id;

    public function getId()
    {
        return $this->id;
    }
}
