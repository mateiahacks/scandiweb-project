<?php
// src/Entity/Product.php
namespace App\Entity;

use App\Utils\CurrencyConverter;
use App\Types\Price;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: "product")]
class Product {
    
    #[Id, Column(type: 'integer'), GeneratedValue]
    protected $id;

    #[Column(type:'string')]
    protected $name;

    #[Column(type: 'integer')]
    private $category_id;

    #[Column(type: 'string')]
    private $brand;

    #[Column(type: 'string')]
    private $description;

    #[Column(type: 'integer')]
    private $price_in_euro;

    #[Column(type: 'integer')]
    private $quantity;

    #[ManyToOne(targetEntity: Category::class, inversedBy:'products')]
    #[JoinColumn(name:'category_id', referencedColumnName:'id')]
    private $category;

    #[OneToMany(targetEntity: AttributeSet::class, mappedBy:'product')]
    private $attributes;

    #[OneToMany(targetEntity: Image::class, mappedBy: 'product')]
    private $gallery;

    /** 
     * @var Price[]
     */
    private $prices;

    public function __construct() {
        $this->gallery = new ArrayCollection();
        $this->attributes = new ArrayCollection();
        $this->prices = [];
    }

    // Getters and setters
    public function get_id() { return $this->id; }
    public function get_name() { return $this->name; }
    public function get_category_id() { return $this->category_id; }
    public function get_brand(): string { return $this->brand; }
    public function get_description(): string { return $this->description; }
    public function get_quatity(): int { return $this->quantity; }
    public function get_price_in_euro(): int { return $this->price_in_euro; }
    public function get_category(): Category { return $this->category; }
    /**
     * @return ArrayCollection|Price[]
     */
    public function get_prices() { return $this->prices; }
    public function set_name($name) { $this->name = $name; }
    public function set_quantity(int $number) { 
        if ($number < 0) {
            throw new \InvalidArgumentException('Quantity should be equal or greater than 0');
        }
        $this->quantity = $number; 
    }
    public function set_prices($amount_in_eur) {
        $currencies = CurrencyConverter::get_avaible_currencies();
        foreach ($currencies as $currency) {
            $this->prices[] = new Price(CurrencyConverter::convert_from_euro($amount_in_eur, $currency->get_symbol()), $currency->get_symbol());
        }   
    }

    public function get_gallery(): ArrayCollection { return $this->gallery; }
    public function get_attributes(): ArrayCollection { return $this->attributes; }
}
