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

use OAuth2Framework\Component\Server\Model\UserAccount\UserAccountId;
use OAuth2Framework\Component\Server\Model\UserAccount\UserAccountRepositoryInterface;

final class UserRepository implements UserAccountRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findOneByUsername(string $username)
    {
        //return array_key_exists($username, $this->usersByUsername) ? $this->usersByUsername[$username] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function findUserAccount(UserAccountId $publicId)
    {
        //return array_key_exists($publicId->getValue(), $this->usersByPublicId) ? $this->usersByPublicId[$publicId->getValue()] : null;
    }
}
