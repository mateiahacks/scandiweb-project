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
#[Table(name:"orders")]
class Order {
    #[Id, Column(type:"integer"), GeneratedValue]
    private $id;

    #[Column(type: 'datetime', options: ["default" => "CURRENT_TIMESTAMP"], nullable: true), GeneratedValue]
    private $created_at;

    #[Column(type: "float")]
    private $total_cost_in_euro;

    #[OneToMany(targetEntity: OrderItem::class, mappedBy: "order")]
    private $order_items;

    public function __construct() {
        $this->order_items = new ArrayCollection();
        $this->created_at = new \DateTime();
    }

    public function get_id(): int {
        return $this->id;
    }

    public function get_total_cost_in_euro(): float {
        return $this->total_cost_in_euro;
    }

    public function set_total_cost_in_euro(float $cost) {
        if ($cost < 0) {
            throw new \InvalidArgumentException("Cost should be greater or equal to 0");
        }
        $this->total_cost_in_euro = $cost;
        return $this;
    }

    public function get_created_at() {
        return $this->created_at;
    }

    public function get_order_items() {
        return $this->order_items;
    }

    public function add_order_item(OrderItem $new) {
        $this->order_items->add($new);
    }
}