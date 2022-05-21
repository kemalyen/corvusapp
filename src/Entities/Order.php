<?php
namespace Corvus\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Column;


#[Entity]
#[Table('orders')]
class Order
{
    #[Id]
    #[Column, GeneratedValue]
    private int $id;

    #[Column(name: 'order_number', unique: true)]
    private string $orderNumber;    

    #[Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private float $amount;

    #[Column(name: 'created_at')]
    private \DateTime $createdAt;

    #[OneToMany(targetEntity: OrderedProduct::class, mappedBy: 'order', cascade: ['persist', 'remove'])]
    private $ordered_products;

    public function __construct()
    {
        $this->ordered_products = new ArrayCollection();
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): Order
    {
        $this->amount = $amount;

        return $this;
    }

    public function getOrderNumber(): string
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(string $orderNumber): Order
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }
 
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): Order
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<OrderedProduct>
     */
    public function getOrderedProduct(): Collection
    {
        return $this->items;
    }

    public function addOrderedProduct(OrderedProduct $item): Order
    {
        $item->setOrder($this);

        $this->ordered_products->add($item);

        return $this;
    }
}