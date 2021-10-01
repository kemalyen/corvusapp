<?php
namespace Corvus\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\HasLifecycleCallbacks;
use Corvus\Exceptions\OrderRequiresException;

/**
 * @ORM\Entity
 * @ORM\Table(name="order_lines")
 * @ORM\HasLifecycleCallbacks()
 */
class OrderLine
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;
 
    /**
     * @ORM\Column(type="string")
     */
    protected $sku;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $title;

    /**
     * @ORM\Column(type="integer")
     */
    protected $quantity;

    /**
    * @ORM\Column(type="decimal", precision=7, scale=2)
     */
    protected $amount;
    
    /**
     * @ManyToOne(targetEntity="Order", inversedBy="id")
     * @JoinColumn(name="order_id", referencedColumnName="id")
     */
    private $order;    

    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of amount
     */ 
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set the value of amount
     *
     * @return  self
     */ 
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of quantity
     */ 
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     *
     * @return  self
     */ 
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get the value of order
     */ 
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set the value of order
     *
     * @return  self
     */ 
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    public function __construct($sku, $title, $quantity, $amount)
   {
        $this->setSku($sku);
        $this->setTitle($title);
        $this->setQuantity($quantity);
        $this->setAmount($amount);
    }

    /**
     * Get the value of sku
     */ 
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Set the value of sku
     *
     * @return  self
     */ 
    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
    * @Orm\PrePersist @Orm\PreUpdate
     */
    public function validate()
    {
        if ($this->sku == null) {
            throw new OrderRequiresException('SKU is required!');
        }

        if (!intval($this->quantity)) {
            throw new OrderRequiresException('Quantity is required!');
        }       
        
        if (!is_numeric($this->amount)) {
            throw new OrderRequiresException('Amount is required!');
        }               
    }
}
