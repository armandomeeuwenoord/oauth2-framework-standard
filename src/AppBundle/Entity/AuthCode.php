<?php

namespace AppBundle\Entity;

use SpomkyLabs\OAuth2ServerBundle\Plugin\AuthCodeGrantTypePlugin\Model\AuthCode as Base;

class AuthCode extends Base
{
    private $id;

    public function getId()
    {
        return $this->id;
    }
}
