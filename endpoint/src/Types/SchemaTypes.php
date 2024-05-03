<?php
namespace App\Types;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\ObjectType;

class SchemaTypes {
    // Define Types
    public static $currency;
    public static $price;
    public static $product;
    public static $attributeSet;
    public static $attributeItem;
    public static $products;
    public static $category;
    public static $categories;
    public static $categoryInput;

    public static function init() {
        self::$currency = new ObjectType([
            'name' => 'Currency',
            'fields'=> [
                'label'=> Type::string(),
                'symbol' => Type::string()
            ]
        ]);

        self::$price = new ObjectType([
            'name'=> 'Price',
            'fields'=> [
                'amount' => Type::float(),
                'currency' => self::$currency,
            ]
        ]);

        self::$attributeItem = new ObjectType([
            'name'=> 'AttributeItem',
            'fields'=> [
                'displayValue' => Type::string(),
                'value' => Type::string(),
                'id' => Type::int(),   
            ]
        ]);

        self::$attributeSet = new ObjectType([
            'name' => 'AttributeSet',
            'fields'=> [
                "id" => Type::int(),
                "name"=> Type::string(),
                "items" => new ListOfType(self::$attributeItem),
                "type" => Type::string(),
            ]
        ]);

        self::$product = new ObjectType([
            'name' => 'Product',
            'fields'=> [
                'id' => Type::int(),
                'name'=> Type::string(),
                'brand' => Type::string(),
                'description' => Type::string(),
                'inStock' => Type::boolean(),
                'gallery'=> new ListOfType(Type::string()),
                'prices' => new ListOfType(self::$price),
                'attributes' => new ListOfType(self::$attributeSet),
            ]
        ]);

        self::$products = new ListOfType(self::$product);

        self::$category = new ObjectType([
            'name' => 'Category',
            'fields' => [
                'name' => Type::string(),
                'products' => self::$products,
            ],
        ]);

        self::$categories = new ListOfType(self::$category);

        self::$categoryInput = new ObjectType([
            'name' => 'CategoryInput',
            'fields'=> [
                'title' => Type::string(),
            ],
        ]);
    }
}

?>
