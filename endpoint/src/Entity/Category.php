<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: "category")]
class Category {
    #[Id, Column(type: "integer"), GeneratedValue]
    private $id;

    #[Column(type:"string")]
    private $name;

    #[OneToMany(targetEntity: Product::class, mappedBy:"category")]
    private $products;

    public function __construct() {
        $this->products = new ArrayCollection();
    }

    public function get_id (): int { return $this->id; }
    public function get_name (): string { return $this->name; }
    public function get_products (): ArrayCollection { return $this->products; }
}