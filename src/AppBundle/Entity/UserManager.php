<?php

namespace AppBundle\Entity;

use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Doctrine\UserManager as Base;
use FOS\UserBundle\Util\CanonicalizerInterface;
use Oauth2\User\UserInterface as Oauth2UserInterface;
use OAuth2\User\UserManagerInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserManager extends Base implements UserManagerInterface
{
    public function __construct(EncoderFactoryInterface $encoderFactory, CanonicalizerInterface $usernameCanonicalizer, CanonicalizerInterface $emailCanonicalizer, ObjectManager $om, $class)
    {
        parent::__construct($encoderFactory, $usernameCanonicalizer, $emailCanonicalizer, $om, $class);
    }

    /**
     * {@inheritdoc}
     */
    public function getUserFromResource($resource)
    {
        $pos = mb_strpos($resource, '@', 0, 'utf-8');
        if (false === $pos || 0 === $pos) {
            return;
        }
        $encoded_email = mb_substr($resource, 0, $pos, 'utf-8');
        $email = urldecode($encoded_email);
        return $this->findUserByEmail($email);
    }

    /**
     * {@inheritdoc}
     */
    public function checkUserPasswordCredentials(Oauth2UserInterface $user, $password)
    {
        if (!$user instanceof UserInterface) {
            return false;
        }
        $encoder = $this->getEncoder($user);

        return $encoder->isPasswordValid($user->getPassword(), $password);
    }

    /**
     * {@inheritdoc}
     */
    public function getUserByUsername($username)
    {
        return $this->findUserBy(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getUserByPublicId($public_id)
    {
        return $this->findUserBy(['public_id' => $public_id]);
    }
}
