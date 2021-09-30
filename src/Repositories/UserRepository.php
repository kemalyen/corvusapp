<?php

namespace Corvus\Repositories;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Corvus\Entities\User;
use Corvus\Exceptions\GeneralException;

class UserRepository extends EntityRepository
{

}