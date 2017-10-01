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

use Doctrine\ORM\EntityRepository;
use OAuth2Framework\Component\Server\Model\UserAccount\UserAccountId;
use OAuth2Framework\Component\Server\Model\UserAccount\UserAccountRepositoryInterface;

final class UserRepository extends EntityRepository implements UserAccountRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findOneByUsername(string $username)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()
        ->select('u')
        ->from(User::class, 'u')
        ->where('u.username = :username')
        ->setParameter('username', $username);

        return $queryBuilder
            ->getQuery()
            ->getSingleResult();
    }

    /**
     * {@inheritdoc}
     */
    public function findUserAccount(UserAccountId $publicId)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.publicId = :publicId')
            ->setParameter('publicId', $publicId);

        return $queryBuilder
            ->getQuery()
            ->getSingleResult();
    }
}
