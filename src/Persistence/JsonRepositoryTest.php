<?php

namespace ChrisHarrison\JsonRepository\Persistence;

use League\Flysystem\Adapter\NullAdapter;
use League\Flysystem\Filesystem;
use PHPUnit\Framework\TestCase;

class JsonRepositoryTest extends TestCase
{
    public function testConstruct()
    {
        $filesystem = new Filesystem(new NullAdapter);
        $test = new JsonRepository($filesystem, 'test');
        $this->assertInstanceOf(ArrayObjectRepository::class, $test);
    }
}