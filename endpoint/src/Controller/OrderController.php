<?php
namespace App\Controller;

use App\Service\OrderService;
use Doctrine\ORM\EntityManager;

class OrderController {
    private OrderService $order_service;
    
    public function __construct(EntityManager $entity_manager) {
        $this->order_service = new OrderService($entity_manager);
    }

    public function create_order($items) {

        var_dump($items);

        return 1;
    }
}