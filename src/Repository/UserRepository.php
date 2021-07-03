<?php

namespace Corvus\Repository;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Corvus\Entity\User;
use Corvus\Exception\GeneralException;

class UserRepository
{
    /**
     * @var EntityRepository
     */
    private $repository;

    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->repository = $entityManager->getRepository(User::class);
        $this->em = $entityManager;
    }

    public function findAll()
    {
        return $this->repository->findBy(array());
    }

    public function getUser(string $email, string $password)
    {
        return $this->repository->findOneBy(array('email' => $email, 'password' => md5($password)));
    }

    public function getUserByEmail(string $email)
    {
        return $this->repository->findOneBy(array('email' => $email));
    }

    public function createUser(User $user)
    {
        try {
            $this->em->persist($user);
            $this->em->flush();
        } catch (UniqueConstraintViolationException $e) {
            throw new GeneralException($e);
        }

    }
}
