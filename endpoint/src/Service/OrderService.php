<?php

namespace App\Service;

use App\Entity\AttributeItem;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use Doctrine\ORM\EntityManager;
use Exception;
use Throwable;

class OrderService {
    private $product_repository;
    private $entity_manager;
    private $attribute_repository;
    
    public function __construct(EntityManager $entityManager) {
        $this->product_repository = $entityManager->getRepository(Product::class);
        $this->entity_manager = $entityManager;
        $this->attribute_repository = $entityManager->getRepository(AttributeItem::class);
    }

    public function create_order($items) {
            
        $order = new Order();
        $total_cost = 0;

        foreach ($items as $item) {
            $product_id = $item["product_id"];
            $quantity = $item["quantity"];
            $attribute_ids = $item["attribute_ids"];

            $order_item = new OrderItem();
            $product = $this->product_repository->findOneBy(["id" => $product_id]);

            
            if (!$product) {
                return 2;
            }
            
            $order_item->set_product($product)->set_quantity($quantity)->set_order($order);
            
            foreach ($attribute_ids as $id) {
                $attribute = $this->attribute_repository->findOneBy(["id" => $id]);
                
                if (!$attribute) {
                    return 3;
                }
                
                $order_item->add_attribute_item($attribute);
                $attribute->add_order_item($order_item);
                
                // save updated attribute item
                $this->entity_manager->persist($attribute);
            }
            
            $total_cost += $product->get_price_in_euro();
            
            $order->add_order_item($order_item);
            
            // save new order item
            $this->entity_manager->persist($order_item);
        }
        
        $order->set_total_cost_in_euro($total_cost);

        // save new order
        $this->entity_manager->persist($order);

        // commit every presist
        $this->entity_manager->flush();
        return 1;
    }

}