<?php 
namespace App\Entity;
use App\Utils\EntityToArrayTrait;

abstract class EntityBase {
    use EntityToArrayTrait;

    public function to_array(): array {
        return $this->toArray();
    }
}