<?php

namespace App\Model;

use ReflectionClass;

abstract class Action
{
    public function set(array $args) : self
    {
        $reflector = new ReflectionClass(get_class($this));
        foreach($args as $key => $value){
            if(property_exists($this, $key)){
                $prop = $reflector->getProperty($key);
                $prop->setAccessible(true);
                $prop->setValue($this, $value);
            }
        }

        return $this;
    }

    public function toArray() : array
    {
        $fields = [];
        $reflector = new ReflectionClass(get_class($this));
        foreach($reflector->getProperties() as $propery){
            $propery->setAccessible(true);
            $fields[$propery->getName()] = $propery->getValue($this);
        }

        return $fields;
    }
}