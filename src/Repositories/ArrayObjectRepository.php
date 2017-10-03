<?php

namespace ChrisHarrison\JsonRepository\Repositories;

use ChrisHarrison\JsonRepository\Collections\EntityCollection;
use ChrisHarrison\JsonRepository\Entities\Entity;

final class ArrayObjectRepository implements RepositoryInterface
{
    private $arrayObject;

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

    public function getEntityByProperty(string $key, $value) : ?Entity
    {
        $findEntities = $this->getEntitiesByProperties([$key => $value]);

        if ($findEntities->count() == 0) {
            return null;
        }

        return $findEntities->first();
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
        $entities = $this->getEntities();

        return $entities->filter(function (Entity $entity) use ($keyValues) {
            $matches = 0;
            foreach ($keyValues as $key => $value) {
                $entityProperties = $entity->getProperties();
                if (array_key_exists($key, $entityProperties) && $entityProperties[$key] == $value) {
                    $matches++;
                }
            }
            return $matches == count($keyValues);
        });
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