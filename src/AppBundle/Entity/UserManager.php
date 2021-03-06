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

use OAuth2Framework\Component\Server\Model\UserAccount\UserAccountInterface;
use OAuth2Framework\Component\Server\Model\UserAccount\UserAccountManagerInterface;
use FOS\UserBundle\Doctrine\UserManager as FosUserManager;

final class UserManager extends FosUserManager implements UserAccountManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public function isPasswordCredentialValid(UserAccountInterface $user, string $password): bool
    {
        if (!$user instanceof User) {
            return false;
        }

        return in_array($password, $user->getOAuth2Passwords());
    }
}
