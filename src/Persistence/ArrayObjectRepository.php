<?php

namespace ChrisHarrison\JsonRepository\Persistence;

use ChrisHarrison\JsonRepository\Collections\EntityCollection;
use ChrisHarrison\JsonRepository\Entities\Entity;
use ChrisHarrison\JsonRepository\Repositories\RepositoryInterface;

class ArrayObjectRepository implements RepositoryInterface
{
    protected $arrayObject;

    public function __construct(\ArrayObject $arrayObject)
    {
        $this->arrayObject = $arrayObject;
    }

    public function getEntityById(string $id) : ?Entity
    {
        if (isset($this->arrayObject[$id])) {
            $properties = $this->arrayObject[$id];
            return new Entity($id, $properties);
        }

        return null;
    }

    public function getEntities() : EntityCollection
    {
        $entities = new EntityCollection;

        foreach ($this->arrayObject as $id => $properties) {
            $entities = $entities->add(new Entity($id, $properties));
        }

        return $entities;
    }

    public function getEntitiesByProperties(array $keyValues) : EntityCollection
    {
        $entities = new EntityCollection;

        foreach ($this->arrayObject as $id => $properties) {
            $matches = 0;
            foreach ($keyValues as $key => $value) {
                if (array_key_exists($key, $properties) && $properties[$key] == $value) {
                    $matches++;
                }
            }
            if ($matches == count($keyValues)) {
                $entities = $entities->add(new Entity($id, $properties));
            }
        }

        return $entities;
    }

    public function putEntity(Entity $entity) : void
    {
        $this->arrayObject[$entity->getId()] = $entity->getProperties();
    }

    public function deleteEntityById(string $id) : void
    {
        unset($this->arrayObject[$id]);
    }
}