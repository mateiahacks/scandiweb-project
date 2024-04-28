<?php 
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\ObjectType;

// Define Types
$productType = new ObjectType([
    'name' => 'Product',
    'fields'=> [
        'id' => Type::string(),
        'name'=> Type::string(),
    ]
]);

$productsType = new ListOfType($productType);

$categoryType = new ObjectType([
    'name' => 'Category',
    'fields' => [
        'name' => Type::string(),
        'products' => $productsType,
    ],
]);

$categoriesType = new ListOfType($categoryType);

$categoryInputType = new ObjectType([
    'name' => 'CategoryInput',
    'fields'=> [
        'title' => Type::string(),
    ],
]);