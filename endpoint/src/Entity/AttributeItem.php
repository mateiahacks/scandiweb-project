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
#[Table(name:"attribute_item")]
class AttributeItem extends EntityBase {
    #[Id, Column(type:"integer"), GeneratedValue]
    private $id;

    #[Column(type: "integer")]
    private $attribute_set_id;

    #[Column(type:"string")]
    private $display_value;

    #[Column(type:"string")]
    private $value;

    #[Column(type: "integer", nullable: true)]
    private $order_item_id;

    #[ManyToOne(targetEntity: OrderItem::class, inversedBy: "attribute_items")]
    #[JoinColumn(name: "order_item_id", referencedColumnName: "id")]
    private $order_item;

    #[ManyToOne(targetEntity: AttributeSet::class, inversedBy:"items")]
    #[JoinColumn(name:"attribute_set_id", referencedColumnName:"id")]
    private AttributeSet $attribute_set;

    public function get_id(): int { return $this->id; }
    public function get_display_value(): string { return $this->display_value; }
    public function get_value(): string { return $this->value; }
    public function get_attribute_set_id(): int { return $this->attribute_set_id; }
    public function get_attribute_set(): AttributeSet { return $this->attribute_set; }
    public function get_order_item(): OrderItem { return $this->order_item; }
    public function set_order_item(OrderItem $order_item) { $this->order_item = $order_item; }
    public function get_order_item_id(): int { return $this->order_item_id; }
}