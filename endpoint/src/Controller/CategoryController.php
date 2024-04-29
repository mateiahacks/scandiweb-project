<?php 
namespace App\Controller;

use App\Entity\Category;
use App\Service\CategoryService;
use Doctrine\Common\Collections\ArrayCollection;

class CategoryController {
    private CategoryService $category_service;

    public function __construct($entityManager) {
        $this->category_service = new CategoryService($entityManager);
    }

    public function get_category_by_name($name) {
        $category = $this->category_service->get_category_by_name($name);
        return $category;
    }
    function object_to_array($data)
    {   
        if ($data===null) {
            return [];
        }
        $result = [];
        foreach ($data as $key => $value)
        {
            $result[$key] = (is_array($value) || is_object($value)) ? $this->object_to_array($value) : $value;
        }
        return $result;
    }

    public function get_all_categories() {
        $categories = $this->category_service->get_all_categories();
        $result = array_map(function(Category $category) {
            return [
                "name"=> $category->get_name(),
                "products"=> array_map(fn ($product) => $product->to_array(), $category->get_products()->toArray()),
            ];
        }, $categories);
        return $result;
    }
}