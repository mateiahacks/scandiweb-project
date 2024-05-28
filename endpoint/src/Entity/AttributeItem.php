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
#[Table(name:"attribute_item")]
class AttributeItem extends EntityBase {
    #[Id, Column(type:"integer"), GeneratedValue]
    private $id;

    #[Column(type:"string")]
    private $display_value;

    #[Column(type:"string")]
    private $value;

    #[ManyToMany(targetEntity: OrderItem::class, mappedBy: "attribute_items")]
    private $order_items;

    #[ManyToMany(targetEntity: AttributeSet::class, inversedBy:"items")]
    #[JoinTable(name:"attribute_set_items")]
    private $attribute_sets;

    public function __construct() {
        $this->order_items = new ArrayCollection();
        $this->attribute_sets = new ArrayCollection();
    }

    public function get_id(): int { return $this->id; }
    public function get_display_value(): string { return $this->display_value; }
    public function get_value(): string { return $this->value; }
    public function get_attribute_sets() { return $this->attribute_sets; }
    public function get_order_items() { return $this->order_items; }
    public function add_order_item(OrderItem $order_item) { $this->order_items->add($order_item); }
    public function add_attribute_set(AttributeSet $set) { $this->attribute_sets->add($set); }
}