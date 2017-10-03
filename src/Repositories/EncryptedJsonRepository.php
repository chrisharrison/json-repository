<?php

namespace ChrisHarrison\JsonRepository\Repositories;

use ChrisHarrison\JsonRepository\Collections\EntityCollection;
use ChrisHarrison\JsonRepository\Entities\Entity;
use ChrisHarrison\JsonRepository\Persistence\PersistableDocument;
use League\Flysystem\Filesystem;

final class EncryptedJsonRepository implements RepositoryInterface
{
    private $repository;

    public function __construct(Filesystem $filesystem, string $path)
    {
        $this->repository = new ArrayObjectRepository(
            new PersistableDocument(
                $filesystem,
                $path,
                new EncryptedJsonEncoder
            )
        );
    }

    public function getEntityById(string $id) : ?Entity
    {
        return $this->repository->getEntityById($id);
    }

    public function getEntityByProperty(string $key, $value) : ?Entity
    {
        return $this->repository->getEntityByProperty($key, $value);
    }

    public function getEntities() : EntityCollection
    {
        return $this->repository->getEntities();
    }

    public function getEntitiesByProperties(array $keyValues) : EntityCollection
    {
        return $this->repository->getEntitiesByProperties($keyValues);
    }

    public function putEntity(Entity $entity) : void
    {
        $this->repository->putEntity($entity);
    }

    public function deleteEntityById(string $id) : void
    {
        $this->repository->deleteEntityById($id);
    }
}
