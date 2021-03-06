<?php

namespace App\Contracts;

abstract class Arrayable
{
    public function toArray($hideNull = true): array
    {
        $reflection = new \ReflectionClass($this);
        $array = [];
        $properties = $reflection->getProperties(\ReflectionProperty::IS_PROTECTED | \ReflectionProperty::IS_PUBLIC);
        foreach($properties as $property) {
            $propertyName = $property->getName();
            $getterMethod = "get" . ucfirst($propertyName);
            $hasGetter = $reflection->hasMethod($getterMethod);

            $value = null;
            if($hasGetter) {
                $value = $this->$getterMethod();
            } else {
                $value = $this->$propertyName;
            }

            if(!is_null($value)) {
                $array[$propertyName] = $value;
            } else {
                if(!$hideNull) {
                    $array[$propertyName] = $value;
                }
            }
        }

        return $array;
    }
}
