<?php

namespace Corvus\Services;

use Corvus\Entities\Order;
use Corvus\Entities\OrderedProduct;
use Doctrine\ORM\EntityManager;

class OrderService
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

    public function getOrders()
    {
        $orders = $this->entityManager->getRepository(Order::class)->findAll();
        return $orders;
    }

    public function getOrder($id): ?Order
    {
        $order = $this->entityManager->getRepository(Order::class)->find($id);
        return $order;
    }

    public function create($request)
    {
        $order = (new Order())
                    ->setOrderNumber($request['order_number'])
                    ->setCreatedAt(new \DateTime());
       
            $lines = (array)$request['order_lines'];

 
            foreach ($lines as $line) {
                $orderedProduct = (new OrderedProduct())
                                ->setSku($line['sku'])
                                ->setDescription($line['description'])
                                ->setQuantity($line['quantity'])
                                ->setUnitPrice($line['amount']);

                $order->addOrderedProduct($orderedProduct);
                $this->entityManager->persist($orderedProduct);
                                
            }
            $this->entityManager->persist($order);
            $this->entityManager->flush();

      
    }
}
