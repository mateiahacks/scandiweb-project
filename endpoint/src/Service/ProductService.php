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
}