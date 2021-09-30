<?php
namespace Corvus\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

/**
 * @ORM\Entity
 * @ORM\Table(name="order_headers")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;
    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $order_number;

    /**
     * @OneToMany(targetEntity="OrderLine", mappedBy="order", cascade={"persist", "remove"})
     */
    private $order_lines;

    public function getId()
    {
        return $this->id;
    }

    public function getOrderNumber()
    {
        return $this->order_number;
    }

    public function setOrderNumber($order_number)
    {
        $this->order_number = $order_number;
    }

    public function __construct() {
        $this->order_lines = new ArrayCollection();
    }

    public function addOrderLine(OrderLine $order_line): self
    {
        $this->order_lines->add($order_line); 
        $order_line->setOrder($this);
        return $this;
    }

    public function addOrderLines(array $lines): self
    {
        foreach($lines as $line){
            $order_line = new OrderLine($line['sku'], null, $line['quantity'], $line['amount']);
            $this->addOrderLine($order_line);
        }
        return $this;
    }

    /**
     * Get the value of order_lines
     */ 
    public function getOrderLines()
    {
        return $this->order_lines;
    }
}