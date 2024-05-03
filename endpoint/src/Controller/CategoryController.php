<?php 
namespace App\Controller;

use App\Entity\Category;
use App\Entity\Image;
use App\Entity\Product;
use App\Types\Price;

use App\Service\CategoryService;
use App\Service\ProductService;

use App\Utils\Serializers;
use Error;

class CategoryController {
    private CategoryService $category_service;
    private ProductService $product_service;

    public function __construct($entityManager) {
        $this->category_service = new CategoryService($entityManager);
        $this->product_service = new ProductService($entityManager);
    }

    public function get_category_by_name($name) {
        if ($name === "all") {
            return [
                "name" => "all",
                "products" => array_map(fn (Product $product) => Serializers::product($product), $this->product_service->get_all_products()),
            ];
        }
        $category = $this->category_service->get_category_by_name($name);
        return Serializers::category($category);
    }

    public function get_all_categories() {
        $result = array_map(fn (Category $category) => Serializers::category($category), $this->category_service->get_all_categories());

        // Add 'all' category to result manually
        array_push( $result, [
            "name" => "all",
            "products" => array_map(fn (Product $product) => Serializers::product($product), $this->product_service->get_all_products()),
        ] );

        return $result;
    }
}