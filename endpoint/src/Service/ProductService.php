<?php
namespace App\Service;

use App\Entity\Product;

use Doctrine\ORM\EntityManager;

class ProductService {
    private $product_repository;
    public function __construct(EntityManager $entity_manager) {
        $this->product_repository = $entity_manager->getRepository(Product::class);
    }

    public function get_all_products() {
        return $this->product_repository->findAll();
    }

    public function get_product_by_id($id) {
        $product = $this->product_repository->findOneBy(["id"=> $id]);
        if ($product === null) {
            throw new \Exception("Product not found");   
        }
        return $product;
    }
}