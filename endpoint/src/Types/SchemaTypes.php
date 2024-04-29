<?php 
namespace App\Types;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\ObjectType;

class SchemaTypes {
    // Define Types
    public static function currency() {
        return new ObjectType([
            'name' => 'Currency',
            'fields'=> [
                'label'=> Type::string(),
                'symbol' => Type::string()
            ]
        ]);
    }

    public static function price() {
        return new ObjectType([
            'name'=> 'Price',
            'fields'=> [
                'amount' => Type::float(),
                'currency' => self::currency(),
            ]
        ]);
    }

    public static function product() {
        return new ObjectType([
            'name' => 'Product',
            'fields'=> [
                'id' => Type::int(),
                'name'=> Type::string(),
                'brand' => Type::string(),
                'gallery'=> new ListOfType(Type::string()),
                'prices' => new ListOfType(self::price()),
                'attributes' => new ListOfType(self::attribute_set()),
            ]
        ]);
    }

    public static function attribute_set() {
        return new ObjectType([
            'name' => 'AttributeSet',
            'fields'=> [
                "id" => Type::int(),
                "name"=> Type::string(),
                "items" => new ListOfType(self::attribute_item()),
                "type" => Type::string(),
            ]
        ]);
    }

    public static function attribute_item() {
        return new ObjectType([
            'name'=> 'AttributeItem',
            'fields'=> [
                'displayValue' => Type::string(),
                'value' => Type::string(),
                'id' => Type::int(),   
            ]
        ]);
    }

    public static function products() {
        return new ListOfType(self::product());
    }

    public static function category() {
        return new ObjectType([
            'name' => 'Category',
            'fields' => [
                'name' => Type::string(),
                'products' => self::products(),
            ],
        ]);
    }   

    public static function categories() {
        return new ListOfType(self::category());
    }

    public static function category_input() {
        return new ObjectType([
            'name' => 'CategoryInput',
            'fields'=> [
                'title' => Type::string(),
            ],
        ]);
    }
}