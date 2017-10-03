<?php

namespace ChrisHarrison\JsonRepository\Repositories;

use League\Flysystem\Adapter\NullAdapter;
use League\Flysystem\Filesystem;
use PHPUnit\Framework\TestCase;

class JsonRepositoryTest extends TestCase
{
    public function testConstruct()
    {
        $filesystem = new Filesystem(new NullAdapter);
        $test = new JsonRepository($filesystem, 'test');
        $this->assertInstanceOf(RepositoryInterface::class, $test);
    }
}
