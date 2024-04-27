<?php
namespace App\Service;

use App\Entity\Category;

use Doctrine\ORM\EntityManager;

class CategoryService {
    private $entity_manager;
    public function __construct(EntityManager $entity_manager) {
        $this->entity_manager = $entity_manager;
    }

    public function get_category_by_name($name) {
        $category = $this->entity_manager->getRepository(Category::class)->findOneBy(["name"=> $name]);
        return $category;
    }
}