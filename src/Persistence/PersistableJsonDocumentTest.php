<?php

namespace ChrisHarrison\JsonRepository\Persistence;

use PHPUnit\Framework\TestCase;
use League\Flysystem\FilesystemInterface;
use League\Flysystem\Filesystem;
use League\Flysystem\Memory\MemoryAdapter;

class PersistableJsonDocumentTest extends TestCase
{
    const PATH = 'test.json';
    
    private function filesystem() : FilesystemInterface
    {
        return new Filesystem(new MemoryAdapter());
    }
    
    public function testOffsetExists()
    {
        $test = new PersistableJsonDocument($this->filesystem(), static::PATH, ['key' => 'value']);
        $this->assertTrue($test->offsetExists('key'));
        $this->assertFalse($test->offsetExists('dummy'));
    }

    public function testOffsetGet()
    {
        $test = new PersistableJsonDocument($this->filesystem(), static::PATH, ['key' => 'value']);
        $this->assertEquals('value', $test->offsetGet('key'));
    }

    public function testOffsetSet()
    {
        $write = new PersistableJsonDocument($this->filesystem(), static::PATH, ['key' => 'value']);
        $write->offsetSet('key2', 'value2');
        $this->assertEquals('value2', $write['key2']);

        $read = new PersistableJsonDocument($this->filesystem(), static::PATH);
        $this->assertEquals('value', $read['key']);
        $this->assertEquals('value2', $read['key2']);
    }

    public function testOffsetUnset()
    {
        $write = new PersistableJsonDocument($this->filesystem(), static::PATH, [
            'setKey' => 'setValue',
            'unsetKey' => 'unsetValue'
        ]);
        $write->offsetUnset('unsetKey');
        $this->assertTrue($write->offsetExists('setKey'));
        $this->assertFalse($write->offsetExists('unsetKey'));

        $read = new PersistableJsonDocument($this->filesystem(), static::PATH);
        $this->assertEquals('setValue', $read['setKey']);
        $this->assertFalse($read->offsetExists('unsetKey'));
    }
}
