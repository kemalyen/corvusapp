<?php
namespace Corvus\Entities;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Column;

#[Entity]
#[Table('products')]
class Product
{
    #[Id]
    #[Column, GeneratedValue]
    private int $id;

    #[Column(name: 'sku', unique: true)]
    protected string  $sku;

    #[Column]
    protected string $description;

    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Get the value of title
     */ 
    public function getDescriptione() : string
    {
        return $this->description;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setDescription($description): Product
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of sku
     */ 
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * Set the value of sku
     *
     * @return  self
     */ 
    public function setSku($sku): Product
    {
        $this->sku = $sku;

        return $this;
    }
}
