<?php

declare(strict_types=1);

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2017 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace AppBundle\Entity;

use Assert\Assertion;
use OAuth2Framework\Component\Server\Model\ResourceOwner\ResourceOwnerId;
use OAuth2Framework\Component\Server\Model\UserAccount\UserAccountId;
use OAuth2Framework\Component\Server\Model\UserAccount\UserAccountInterface;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\UserRepository")
 */
class User extends BaseUser implements UserAccountInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $publicId;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var integer|null
     */
    protected $lastLoginAt = null;

    /**
     * @ORM\Column(type="array")
     * @var array
     */
    protected $parameters = [];

    public function __construct()
    {
        parent::__construct();
        $this->publicId = Uuid::uuid4()->toString();
    }

    /**
     * @return ResourceOwnerId
     */
    public function getPublicId(): ResourceOwnerId
    {
        return UserAccountId::create($this->publicId);
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getLastLoginAt()
    {
        return $this->lastLoginAt ? (new \DateTimeImmutable())->setTimestamp($this->lastLoginAt) : null;
    }

    /**
     * {@inheritdoc}
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $key)
    {
        Assertion::true($this->has($key), sprintf('Configuration value with key \'%s\' does not exist.', $key));

        return $this->parameters[$key];
    }
}
