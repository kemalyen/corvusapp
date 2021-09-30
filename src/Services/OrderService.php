<?php

namespace Corvus\Services;

use Doctrine\ORM\EntityManager;
use Corvus\Entities\Order;
use Corvus\Entities\OrderLine;

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
        $orders = $this->entityManager->getRepository(Order::class)->findBy(array());
        return $orders;
    }

    public function getOrder($id): ?Order
    {
        $order = $this->entityManager->getRepository(Order::class)->find($id);
        return $order;
    }    
 
    public function create($request)
    {
        try {
        $order = new Order();
        $order->setOrderNumber($request['order_number']);
        $lines = $request['order_lines'];
        foreach($lines as $line){
            $order->addOrderLine(new OrderLine($line['sku'], null, $line['quantity'], $line['amount']));
        }
        $this->entityManager->persist($order);
        $this->entityManager->flush();

    } catch (UniqueConstraintViolationException $e) {
        throw new GeneralException($e);
    }
    }
}