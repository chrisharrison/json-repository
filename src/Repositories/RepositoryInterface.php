<?php

namespace ChrisHarrison\JsonRepository\Repositories;

use ChrisHarrison\JsonRepository\Entities\Entity;

interface RepositoryInterface
{
    public function getEntityById(string $id) : ?Entity;
    public function putEntity(Entity $entity) : void;
    public function deleteEntityById(string $id) : void;
}