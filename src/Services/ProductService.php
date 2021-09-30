<?php

namespace Corvus\Services;

use Doctrine\ORM\EntityManager;
use Corvus\Entities\Product;

class ProductService
{
    /**
     * @var EntityManager;
     */    
    private $entityManager;

    /**
     * @Inject
     * @var Psr\Log\LoggerInterface
     */    
    private $logger;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getProducts()
    {
        $products = $this->entityManager->getRepository(Product::class)->findBy(array());
        return $products;
    }

    public function getProduct($id = 0)
    {
        $product = $this->entityManager->getRepository(Product::class)->find($id);
        return $product;
    }
}