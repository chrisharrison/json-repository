<?php

namespace ChrisHarrison\JsonRepository\Entities;

final class Entity
{
    private $id;
    private $properties;

    public function __construct(string $id, array $properties)
    {
        $this->id = $id;
        $this->properties = $properties;
    }

    public function getId() : string
    {
        return $this->id;
    }

    public function getProperty(string $key)
    {
        return (array_key_exists($key, $this->properties)) ? $this->properties[$key] : null;
    }

    public function getProperties() : array
    {
        return $this->properties;
    }
}
