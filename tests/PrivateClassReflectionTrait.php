<?php

declare(strict_types=1);

namespace DsaTests;

use ReflectionClass;

trait PrivateClassReflectionTrait
{
    /**
     * Return a private or protected method from a class
     *
     * @param object $class Class from which to return the method
     * @param string $method Method name to return
     * @return ReflectionMethod
     */
    private function getPrivateMethod($class, $method)
    {
        $reflection = new ReflectionClass($class);
        $method = $reflection->getMethod($method);
        $method->setAccessible(true);
        return $method;
    }

    /**
     * Return a private or protected property value from a class
     *
     * @param object $class Class from which to return the method
     * @param string $name Property name to return
     * @return mixed
     */
    private function getPrivateProperty($class, $name)
    {
        $reflection = new ReflectionClass($class);
        $property = $reflection->getProperty($name);
        $property->setAccessible(true);
        return $property->getValue($class);
    }

    /**
     * Set or update the value of a private or protected property in a class
     *
     * @param object $class Class on which to set the property
     * @param string $name Property name to set or update
     * @param mixed $value Property value
     */
    private function setPrivateProperty($class, $name, $value)
    {
        $reflection = new ReflectionClass($class);
        $property = $reflection->getProperty($name);
        $property->setAccessible(true);
        $property->setValue($class, $value);
    }
}
