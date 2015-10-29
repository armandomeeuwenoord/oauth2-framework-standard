<?php

namespace AppBundle\Entity;

use Base64Url\Base64Url;
use FOS\UserBundle\Model\User as Base;
use OAuth2\EndUser\EndUserInterface;

class User extends Base implements EndUserInterface
{
    protected $id;

    /**
     * @var string
     */
    protected $public_id;

    /**
     * @var string
     */
    protected $type;

    public function __construct()
    {
        parent::__construct();
        $this->setType('end_user');
        $this->setPublicId(trim(chunk_split(Base64Url::encode(uniqid(mt_rand(), true)), 16, '-'), '-'));
    }

    /**
     * {@inheritdoc}
     */
    public function getLastLoginAt()
    {
        return $this->getLastLogin()->getTimestamp();
    }

    /**
     * {@inheritdoc}
     */
    public function setLastLoginAt($last_login_at)
    {
        $time = new \DateTime();
        $time->setTimestamp($last_login_at);
        $this->setLastLogin($time);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPublicId()
    {
        return $this->public_id;
    }

    /**
     * {@inheritdoc}
     */
    public function setPublicId($public_id)
    {
        $this->public_id = $public_id;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }
}
