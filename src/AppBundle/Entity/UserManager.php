<?php

namespace AppBundle\Entity;

use Doctrine\Common\Persistence\ManagerRegistry;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManager as Base;
use OAuth2\EndUser\EndUserInterface;
use OAuth2\EndUser\EndUserManagerInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use FOS\UserBundle\Util\CanonicalizerInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class UserManager extends Base implements EndUserManagerInterface
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    private $entity_repository;

    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    private $entity_manager;

    /**
     * @var string
     */
    private $class;

    /**
     * @param \Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface $encoderFactory
     * @param \FOS\UserBundle\Util\CanonicalizerInterface                      $usernameCanonicalizer
     * @param \FOS\UserBundle\Util\CanonicalizerInterface                      $emailCanonicalizer
     * @param string                                                           $class
     * @param \Doctrine\Common\Persistence\ManagerRegistry                     $manager_registry
     */
    public function __construct(EncoderFactoryInterface $encoderFactory, CanonicalizerInterface $usernameCanonicalizer, CanonicalizerInterface $emailCanonicalizer, $class, ManagerRegistry $manager_registry)
    {
        parent::__construct($encoderFactory, $usernameCanonicalizer, $emailCanonicalizer);
        $this->class = $class;
        $this->entity_manager = $manager_registry->getManagerForClass($class);
        $this->entity_repository = $this->entity_manager->getRepository($class);
    }

    public function createEndUser()
    {
        return $this->createUser();
    }

    public function saveEndUser(EndUserInterface $end_user)
    {
        $this->getEntityManager()->persist($end_user);
        $this->getEntityManager()->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function checkEndUserPasswordCredentials(EndUserInterface $end_user, $password)
    {
        if (!$end_user instanceof UserInterface) {
            return false;
        }

        return $this->getEncoder($end_user)->isPasswordValid($end_user->getPassword(), $password, $end_user->getSalt());
    }

    /**
     * {@inheritdoc}
     */
    public function getEndUser($public_id)
    {
        return $this->findUserBy(['public_id' => $public_id]);
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    protected function getEntityRepository()
    {
        return $this->entity_repository;
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    protected function getEntityManager()
    {
        return $this->entity_manager;
    }

    /**
     * {@inheritDoc}
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * {@inheritDoc}
     */
    public function deleteUser(UserInterface $user)
    {
        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function findUserBy(array $criteria)
    {
        return $this->getEntityRepository()->findOneBy($criteria);
    }

    /**
     * {@inheritDoc}
     */
    public function findUsers()
    {
        return $this->getEntityRepository()->findAll();
    }

    /**
     * {@inheritDoc}
     */
    public function reloadUser(UserInterface $user)
    {
        $this->getEntityManager()->refresh($user);
    }

    /**
     * Updates a user.
     *
     * @param UserInterface $user
     * @param Boolean       $andFlush Whether to flush the changes (default true)
     */
    public function updateUser(UserInterface $user, $andFlush = true)
    {
        $this->updateCanonicalFields($user);
        $this->updatePassword($user);

        $this->getEntityManager()->persist($user);
        if ($andFlush) {
            $this->getEntityManager()->flush();
        }
    }
}
