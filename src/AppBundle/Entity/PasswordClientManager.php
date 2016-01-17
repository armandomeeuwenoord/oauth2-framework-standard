<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\UserInterface;
use SpomkyLabs\OAuth2ServerBundle\Plugin\PasswordClientPlugin\Model\PasswordClientManager as BaseManager;

class PasswordClientManager extends BaseManager
{
    public function getClientsOfUser(UserInterface $user)
    {
        return $this->getEntityRepository()->findBy(['owner' => $user]);
    }
}
