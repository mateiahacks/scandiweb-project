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
#[Table(name:"order")]
class Order {
    #[Id, Column(type:"integer"), GeneratedValue]
    private $id;

    #[Column(type: 'datetime')]
    private $created_at;

    #[OneToMany(targetEntity: OrderItem::class, mappedBy: "order")]
    private $order_items;

    public function __construct() {
        $this->order_items = new ArrayCollection();
    }

    public function get_id(): int {
        return $this->id;
    }

    public function get_created_at() {
        return $this->created_at;
    }

    public function get_order_items() {
        return $this->order_items;
    }
}