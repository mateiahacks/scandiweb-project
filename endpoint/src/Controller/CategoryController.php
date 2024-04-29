<?php 
namespace App\Controller;

use App\Entity\Category;
use App\Entity\Image;
use App\Entity\Product;
use App\Types\Price;

use App\Service\CategoryService;
use App\Service\ProductService;

use App\Utils\Serializers;

class CategoryController {
    private CategoryService $category_service;
    private ProductService $product_service;

    public function __construct($entityManager) {
        $this->category_service = new CategoryService($entityManager);
        $this->product_service = new ProductService($entityManager);
    }

    public function get_category_by_name($name) {
        $category = $this->category_service->get_category_by_name($name);
        return $category;
    }

    public function get_all_categories() {
        $result = array_map(function(Category $category) {
            return [
                "name"=> $category->get_name(),
                "products"=> array_map(fn (Product $product) => Serializers::product($product), $category->get_products()),
            ];
        }, $this->category_service->get_all_categories());

        // Add all category to result manually
        array_push( $result, [
            "name" => "all",
            "products" => array_map(fn (Product $product) => Serializers::product($product), $this->product_service->get_all_products()),
        ] );

        return $result;
    }
}