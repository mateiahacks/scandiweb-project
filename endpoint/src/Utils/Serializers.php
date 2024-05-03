<?php 
namespace App\Utils;

use App\Entity\AttributeItem;
use App\Entity\AttributeSet;
use App\Entity\Category;
use App\Entity\Image;
use App\Entity\Product;
use App\Types\Price;

class Serializers {
    public static function category(Category $category) {
        return [
            "name"=> $category->get_name(),
            "products"=> array_map(fn (Product $product) => self::product($product), $category->get_products()),
        ];
    }

    public static function product( Product $product ) {
        $product->set_prices($product->get_price_in_euro());
        return [
            "id" => $product->get_id(),
            "name" => $product->get_name(),
            "brand" => $product->get_brand(),
            "inStock" => $product->get_quatity() > 0,
            "description" => $product->get_description(),
            "gallery" => array_map(fn (Image $img) => self::image($img), $product->get_gallery()),
            "prices" => array_map(fn (Price $price) => self::price($price), $product->get_prices()),
            "attributes" => array_map(fn (AttributeSet $attribute_set) => self::attribute_set( $attribute_set ), $product->get_attributes()),
        ];
    }

    public static function attribute_set( AttributeSet $attribute_set ) {
        return [
            "id" => $attribute_set->get_id(),
            "name" => $attribute_set->get_name(),
            "items" => array_map(fn (AttributeItem $item) => self::attribute_item($item), $attribute_set->get_items()->toArray()),
            "type" => $attribute_set->get_type(),
        ];
    }

    public static function attribute_item( AttributeItem $item ) {
        return [
            "id" => $item->get_id(),
            "value" => $item->get_value(),
            "displayValue" => $item->get_display_value()
        ];
    }

    public static function price( Price $price ) {
        return [
            "amount" => Helpers::round_to_2_decimals($price->get_amount()),
            "currency" => [
                "label" => $price->get_currency()->get_label(),
                "symbol" => $price->get_currency()->get_symbol(),
            ]
        ];
    }

    public static function image( Image $image ) {
        return $image->get_url();
    }
}