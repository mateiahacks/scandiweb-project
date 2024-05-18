<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\Product;
use Doctrine\ORM\EntityManager;

class OrderService {
    private $product_repository;
    private $order_repository;
    
    public function __construct(EntityManager $entityManager) {
        $this->product_repository = $entityManager->getRepository(Product::class);
        $this->order_repository = $entityManager->getRepository(Order::class);
    }

    public function create_order() {
        
    }

}