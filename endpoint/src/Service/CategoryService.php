<?php
namespace App\Service;

use App\Entity\Category;

use Doctrine\ORM\EntityManager;

class CategoryService {
    private $category_repository;
    public function __construct(EntityManager $entity_manager) {
        $this->category_repository = $entity_manager->getRepository(Category::class);
    }

    public function get_category_by_name($name) {
        $category = $this->category_repository->findOneBy(["name"=> $name]);
        return $category;
    }

    public function get_all_categories() {
        $categories = $this->category_repository->findAll();
        return $categories;
    }
}