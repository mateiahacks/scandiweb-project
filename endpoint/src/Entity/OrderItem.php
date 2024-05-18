<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: "order_item")]
class OrderItem {
    #[Id, Column(type: "integer"), GeneratedValue]
    private $id;

    #[Column(type: "integer")]
    private $quantity;

    #[Column(type: "integer")]
    private $product_id;

    #[Column(type: "integer")]
    private $order_id;

    #[ManyToOne(targetEntity: Product::class)]
    #[JoinColumn(name: "product_id", referencedColumnName: "id")]
    private $product;

    #[ManyToOne(targetEntity: Order::class, inversedBy: "order_item")]
    #[JoinColumn(name: "order_id", referencedColumnName: "id")]
    private $order;

    public function get_id(): int { return $this->id; }

    public function get_product_id(): int { return $this->product_id; }

    public function get_quantity(): int { return $this->quantity; }

    public function get_product(): Product {
        return $this->product;
    }

    public function get_order(): Order {
        return $this->order;
    }

    public function get_order_id(): int {
        return $this->order_id;
    }
}