<?php

namespace ChrisHarrison\JsonRepository\Persistence;

use PHPUnit\Framework\TestCase;
use League\Flysystem\FilesystemInterface;
use League\Flysystem\Filesystem;
use League\Flysystem\Memory\MemoryAdapter;

class PersistableDocumentTest extends TestCase
{
    const PATH = 'test';
    
    private function filesystem() : FilesystemInterface
    {
        return new Filesystem(new MemoryAdapter());
    }
    
    public function testOffsetExists()
    {
        $test = new _PersistableDocument($this->filesystem(), static::PATH, ['key' => 'value']);
        $this->assertTrue($test->offsetExists('key'));
        $this->assertFalse($test->offsetExists('dummy'));
    }

    public function testOffsetGet()
    {
        $test = new _PersistableDocument($this->filesystem(), static::PATH, ['key' => 'value']);
        $this->assertEquals('value', $test->offsetGet('key'));
    }

    public function testOffsetSet()
    {
        $filesystem = $this->filesystem();
        
        $write = new _PersistableDocument($filesystem, static::PATH, ['key' => 'value']);
        $write->offsetSet('key2', 'value2');
        $this->assertEquals('value2', $write['key2']);

        $read = new _PersistableDocument($filesystem, static::PATH);
        $this->assertEquals('value', $read['key']);
        $this->assertEquals('value2', $read['key2']);
    }

    public function testOffsetUnset()
    {
        $filesystem = $this->filesystem();
        
        $write = new _PersistableDocument($filesystem, static::PATH, [
            'setKey' => 'setValue',
            'unsetKey' => 'unsetValue'
        ]);
        $write->offsetUnset('unsetKey');
        $this->assertTrue($write->offsetExists('setKey'));
        $this->assertFalse($write->offsetExists('unsetKey'));

        $read = new _PersistableDocument($filesystem, static::PATH);
        $this->assertEquals('setValue', $read['setKey']);
        $this->assertFalse($read->offsetExists('unsetKey'));
    }
}

class _PersistableDocument extends PersistableDocument
{
    public function encode() : string
    {
        return json_encode($this);
    }

    public function decode(string $content) : array
    {
        return json_decode($content, true);
    }
}
