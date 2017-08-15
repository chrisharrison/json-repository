<?php

namespace ChrisHarrison\JsonRepository\Repositories;

use ChrisHarrison\JsonRepository\Entities\Entity;
use ChrisHarrison\JsonRepository\Collections\EntityCollection;

interface RepositoryInterface
{
    public function getEntityById(string $id) : ?Entity;
    public function getEntities() : EntityCollection;
    public function getEntitiesByProperties(array $keyValues) : EntityCollection;
    public function putEntity(Entity $entity) : void;
    public function deleteEntityById(string $id) : void;
}