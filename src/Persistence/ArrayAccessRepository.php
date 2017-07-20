<?php

namespace ChrisHarrison\JsonRepository\Persistence;

use ChrisHarrison\JsonRepository\Entities\Entity;
use ChrisHarrison\JsonRepository\Repositories\RepositoryInterface;

class ArrayAccessRepository implements RepositoryInterface
{
    protected $arrayAccess;

    public function __construct(\ArrayAccess $arrayAccess)
    {
        $this->arrayAccess = $arrayAccess;
    }

    public function getEntityById(string $id) : ?Entity
    {
        if (isset($this->arrayAccess[$id])) {
            $item = $this->arrayAccess[$id];
            return new Entity($id, $item);
        }

        return null;
    }

    public function putEntity(Entity $entity) : void
    {
        $this->arrayAccess[$entity->getId()] = $entity->getProperties();
    }

    public function deleteEntityById(string $id) : void
    {
        unset($this->arrayAccess[$id]);
    }
}