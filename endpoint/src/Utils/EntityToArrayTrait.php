<?php
// src/Utils/EntityToArrayTrait.php

namespace App\Utils;

trait EntityToArrayTrait {
    public function toArray(): array {
        $data = [];
        $reflectionClass = new \ReflectionClass($this);
        $properties = $reflectionClass->getProperties();
        
        foreach ($properties as $property) {
            $property->setAccessible(true);
            $propertyName = $property->getName();
            $propertyValue = $property->getValue($this);

            if (is_object($propertyValue) && method_exists($propertyValue, 'toArray')) {
                $data[$propertyName] = $propertyValue->toArray(); // Recursively convert object properties
            } elseif (is_array($propertyValue)) {
                $data[$propertyName] = $this->convertArrayToAssociative($propertyValue); // Handle array properties
            } else {
                $data[$propertyName] = $propertyValue; // Non-object and non-array properties
            }
        }

        return $data;
    }

    private function convertArrayToAssociative(array $array): array {
        $result = [];
        foreach ($array as $key => $value) {
            if (is_object($value) && method_exists($value, 'toArray')) {
                $result[$key] = $value->toArray(); // Recursively convert object arrays
            } elseif (is_array($value)) {
                $result[$key] = $this->convertArrayToAssociative($value); // Recursively convert nested arrays
            } else {
                $result[$key] = $value; // Non-object and non-array values
            }
        }
        return $result;
    }
}
