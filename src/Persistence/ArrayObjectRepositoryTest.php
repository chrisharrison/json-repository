<?php

namespace ChrisHarrison\JsonRepository\Persistence;

use ChrisHarrison\JsonRepository\Entities\Entity;
use PHPUnit\Framework\TestCase;

class ArrayObjectRepositoryTest extends TestCase
{
    public function testGetEntityById()
    {
        $arrayObject = new \ArrayObject([
            'test-id' => [
                'key' => 'value'
            ]
        ]);

        $repository = new ArrayObjectRepository($arrayObject);

        $entity = $repository->getEntityById('test-id');

        $this->assertEquals('test-id', $entity->getId());
        $this->assertEquals('value', $entity->getProperty('key'));

        $this->assertNull($repository->getEntityById('dummy-id'));
    }

    public function testGetEntitiesByProperties()
    {
        $arrayObject = new \ArrayObject([
            'dummy-id-1' => [
                'key1' => 'value1'
            ],
            'dummy-id-2' => [
                'key1' => 'value1',
                'key2' => 'value2'
            ]
        ]);

        $repository = new ArrayObjectRepository($arrayObject);

        $query1 = $repository->getEntitiesByProperties(
            ['key1' => 'value1']
        );
        $query2 = $repository->getEntitiesByProperties(
            ['key1' => 'value1', 'key2' => 'value2']
        );
        $query3 = $repository->getEntitiesByProperties(
            ['key3' => 'value3']
        );
        $query4 = $repository->getEntitiesByProperties(
            ['key1' => 'non-existent']
        );

        $this->assertEquals(2, $query1->count());
        $this->assertEquals(1, $query2->count());
        $this->assertEquals(0, $query3->count());
        $this->assertEquals(0, $query4->count());
    }

    public function testPutEntity()
    {
        $arrayObject = new \ArrayObject;
        $repository = new ArrayObjectRepository($arrayObject);

        $entity = new Entity('test-id', ['key' => 'value']);

        $this->assertNull($repository->getEntityById('test-id'));

        $repository->putEntity($entity);

        $this->assertNotNull($repository->getEntityById('test-id'));
    }

    public function testDeleteEntityById()
    {
        $arrayObject = new \ArrayObject([
            'test-id' => []
        ]);
        $repository = new ArrayObjectRepository($arrayObject);

        $this->assertNotNull($repository->getEntityById('test-id'));

        $repository->deleteEntityById('test-id');

        $this->assertNull($repository->getEntityById('test-id'));
    }
}