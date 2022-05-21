<?php

declare(strict_types = 1);

namespace Corvus\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table('ordered_products')]
class OrderedProduct
{
    #[Id]
    #[Column, GeneratedValue]
    private int $id;
    
    #[Column(name: 'order_id')]
    private int $orderId;

    #[Column(name: 'sku')]
    private string $sku;    

    #[Column]
    private string $description;

    #[Column]
    private int $quantity;

    #[Column(name: 'unit_price', type: Types::DECIMAL, precision: 10, scale: 2)]
    private float $unitPrice;

    #[ManyToOne(inversedBy: 'ordered_products')]
    private Order $order;

    public function getId(): int
    {
        return $this->id;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): OrderedProduct
    {
        $this->description = $description;

        return $this;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function setSku(string $sku): OrderedProduct
    {
        $this->sku = $sku;

        return $this;
    }    

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): OrderedProduct
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(float $unitPrice): OrderedProduct
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function setOrder(Order $order): OrderedProduct
    {
        $this->order = $order;

        return $this;
    }
}