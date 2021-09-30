<?php

namespace Corvus\Repositories;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Corvus\Entities\Product;

class ProductRepository 
{
  /**
     * @var EntityRepository
     */
    private $repository;

    public function __construct(EntityManager $entityManager)
    {
        $this->repository = $entityManager->getRepository(Product::class);
    }

    public function find(int $id): ?Product
    {
        return $this->repository->find($id);
    }

    public function findAll()
    {
        return $this->repository->findBy(array());
    }    
}