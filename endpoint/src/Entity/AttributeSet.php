<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name:"attribute_set")]
#[InheritanceType('SINGLE_TABLE')]
#[DiscriminatorColumn(name: 'type', type: 'string', columnDefinition: "ENUM('text', 'swatch')")]
#[DiscriminatorMap(['text' => TextAttributeSet::class, 'swatch' => SwatchAttributeSet::class])]
abstract class AttributeSet extends EntityBase {

    #[Id, Column(type:"integer"), GeneratedValue]
    private $id;

    #[Column(type: "integer")]
    private $product_id;

    #[Column(type:"string")]
    private $name;

    #[OneToMany(targetEntity: AttributeItem::class, mappedBy:"attribute_set")]
    private $items;

    #[ManyToOne(targetEntity: Product::class, inversedBy:"attributes")]
    #[JoinColumn(name:"product_id", referencedColumnName:"id")]
    private $product;

    public function __construct() {
        $this->items = new ArrayCollection();
    }

    public function get_id (): int { return $this->id; }
    public function get_product_id(): int { return $this->product_id; }
    public function get_product(): Product { return $this->product; }
    public function get_name (): string { return $this->name; }
    public function get_items() { return $this->items; }
    abstract public function get_type();
}

#[Entity]
class SwatchAttributeSet extends AttributeSet {
    // This entity will only read swatch type attribute sets

    public function get_type() {
        return "swatch";
    }
}
#[Entity]
class TextAttributeSet extends AttributeSet {
    // This entity will only read text type attribute sets
    public function get_type() {
        return "text";
    }
}