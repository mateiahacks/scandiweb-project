<?php 
namespace App\Types;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\ObjectType;

class SchemaTypes {
    // Define Types

    public static function product() {
        return new ObjectType([
            'name' => 'Product',
            'fields'=> [
                'id' => Type::int(),
                'name'=> Type::string(),
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