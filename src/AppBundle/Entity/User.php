<?php

namespace AppBundle\Entity;

use Base64Url\Base64Url;
use FOS\UserBundle\Model\User as Base;
use OAuth2\ResourceOwner\ResourceOwnerTrait;
use OAuth2\User\UserInterface;
use OAuth2\User\UserTrait;

class User extends Base implements UserInterface
{
    use ResourceOwnerTrait;
    use UserTrait;
    
    protected $id;

    public function __construct()
    {
        parent::__construct();
        $this->setPublicId(trim(chunk_split(Base64Url::encode(uniqid(mt_rand(), true)), 16, '-'), '-'));
    }
}
