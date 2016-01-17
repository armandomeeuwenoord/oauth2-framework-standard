<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\UserInterface;
use SpomkyLabs\OAuth2ServerBundle\Plugin\PublicClientPlugin\Model\PublicClientManager as Base;

class PublicClientManager extends Base
{
    public function getClientsOfUser(UserInterface $user)
    {
        return $this->getEntityRepository()->findBy(['owner' => $user]);
    }
}
