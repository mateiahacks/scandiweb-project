<?php
// src/Utils/EntityToArrayTrait.php

namespace App\Utils;

trait EntityToArrayTrait {
    public function entityToArray($entity): array {
        $reflectionClass = new \ReflectionClass($entity);
        $properties = $reflectionClass->getProperties();

        $data = [];
        foreach ($properties as $property) {
            $property->setAccessible(true);
            $propertyName = $property->getName();
            $propertyValue = $property->getValue($entity);
            $data[$propertyName] = $propertyValue;
        }

        return $data;
    }
}
