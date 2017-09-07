<?php

namespace ChrisHarrison\JsonRepository\Persistence;

use League\Flysystem\Filesystem;
use League\Flysystem\Memory\MemoryAdapter;
use PHPUnit\Framework\TestCase;

class PersistableJsonDocumentTest extends TestCase
{
    public function testEncode()
    {
        $filesystem = new Filesystem(new MemoryAdapter);
        $test = new PersistableJsonDocument($filesystem, 'test');
        $test['key'] = 'value';
        $encode = $test->encode();
        $this->assertEquals(json_encode(['key' => 'value']), $encode);
    }
}