<?php

namespace ChrisHarrison\JsonRepository\Persistence;

use ChrisHarrison\JsonRepository\Entities\Entity;
use PHPUnit\Framework\TestCase;
use Mockery;

class ArrayAccessRepositoryTest extends TestCase
{
    public function testGetEntityById()
    {
        $arrayAccess = Mockery::mock(\ArrayAccess::class);
        $arrayAccess->shouldReceive('offsetExists')->withArgs(['test-id'])->andReturn(true);
        $arrayAccess->shouldReceive('offsetExists')->withArgs(['dummy-id'])->andReturn(false);
        $arrayAccess->shouldReceive('offsetGet')->withArgs(['test-id'])->andReturn(['key' => 'value']);

        $repository = new ArrayAccessRepository($arrayAccess);

        $entity = $repository->getEntityById('test-id');

        $this->assertEquals('test-id', $entity->getId());
        $this->assertEquals('value', $entity->getProperty('key'));

        $this->assertNull($repository->getEntityById('dummy-id'));
    }

    public function testPutEntity()
    {
        $arrayAccess = Mockery::mock(\ArrayAccess::class);
        $arrayAccess->shouldReceive('offsetSet');
        $repository = new ArrayAccessRepository($arrayAccess);

        $entity = new Entity('test-id', ['key' => 'value']);
        $repository->putEntity($entity);

        //Nothing to assert
    }

    public function testDeleteEntityById()
    {
        $arrayAccess = Mockery::mock(\ArrayAccess::class);
        $arrayAccess->shouldReceive('offsetUnset');
        $repository = new ArrayAccessRepository($arrayAccess);

        $repository->deleteEntityById('test-id');

        //Nothing to assert
    }
}