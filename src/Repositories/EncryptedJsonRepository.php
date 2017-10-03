<?php

namespace ChrisHarrison\JsonRepository\Repositories;

use ChrisHarrison\JsonRepository\Collections\EntityCollection;
use ChrisHarrison\JsonRepository\Entities\Entity;
use ChrisHarrison\JsonRepository\Persistence\Encoders\EncryptedJsonEncoder;
use ChrisHarrison\JsonRepository\Persistence\Encoders\JsonEncoder;
use ChrisHarrison\JsonRepository\Persistence\PersistableDocument;
use League\Flysystem\Filesystem;
use Phlib\Encrypt\EncryptorInterface;

final class EncryptedJsonRepository implements RepositoryInterface
{
    private $repository;

    public function __construct(Filesystem $filesystem, string $path, EncryptorInterface $encryptor, ?array $keysToEncrypt = null)
    {
        $this->repository = new ArrayObjectRepository(
            new PersistableDocument(
                $filesystem,
                $path,
                new EncryptedJsonEncoder(
                    $encryptor,
                    new JsonEncoder,
                    $keysToEncrypt
                )
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
        return;
    }

    public function deleteEntityById(string $id) : void
    {
        $this->repository->deleteEntityById($id);
        return;
    }
}
