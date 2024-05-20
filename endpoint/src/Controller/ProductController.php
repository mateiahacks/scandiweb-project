<?php 
namespace App\Controller;

use App\Service\ProductService;

use App\Utils\Serializers;

class ProductController {
    private ProductService $productService;

    public function __construct($entity_manager) {
        $this->productService = new ProductService($entity_manager);
    }

    public function get_product_by_id(int $id) {
        $product = $this->productService->get_product_by_id($id);
        if (!$product) {
            throw new \Exception("Product with this ID doesn't exist");
        }
        return Serializers::product($product);
    }
}