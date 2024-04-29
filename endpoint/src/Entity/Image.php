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
#[Table(name:"image")]
class Image extends EntityBase {
    #[Id, Column(type: "integer"), GeneratedValue]
    protected $id;

    #[Column(type:"integer")]
    protected $product_id;
    
    #[Column(type:"string")]
    protected $url;

    #[ManyToOne(targetEntity: Product::class, inversedBy:"gallery")]
    #[JoinColumn(name:"product_id", referencedColumnName:"id")]
    protected $product;

    public function get_id(): int { return $this->id; }
    public function get_product(): Product { return $this->product; }
    public function get_url(): string { return $this->url; }
}