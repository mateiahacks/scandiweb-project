<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
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

    #[ManyToMany(targetEntity: AttributeItem::class, inversedBy: 'order_items')]
    #[JoinTable(name: "order_attributes")]
    private $attribute_items;

    public function __construct() {
        $this->attribute_items = new ArrayCollection();
    }

    public function get_id(): int { return $this->id; }

    public function get_product_id(): int { return $this->product_id; }

    public function get_quantity(): int { return $this->quantity; }

    public function set_quantity($quantity) {
        if ($quantity < 0) {
            throw new \InvalidArgumentException("Quantity must be 0 or greater");
        }
        $this->quantity = $quantity;
        return $this;
    }

    public function get_product(): Product {
        return $this->product;
    }

    public function set_product(Product $product) {
        $this->product = $product;
        return $this;
    }

    public function get_order(): Order {
        return $this->order;
    }

    public function set_order(Order $order) { 
        $this->order = $order; 
        return $this;
    }

    public function get_order_id(): int {
        return $this->order_id;
    }

    public function get_attribute_items() {
        return $this->attribute_items;
    }

    public function add_attribute_item(AttributeItem $item) {
        $this->attribute_items->add($item);
        return $this;
    }
}