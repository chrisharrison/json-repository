<?php

namespace ChrisHarrison\JsonRepository\Persistence;

use ChrisHarrison\JsonRepository\Persistence\Encoders\PersistableDocumentEncoder;
use PHPUnit\Framework\TestCase;
use League\Flysystem\FilesystemInterface;
use League\Flysystem\Filesystem;
use League\Flysystem\Memory\MemoryAdapter;

class PersistableDocumentTest extends TestCase
{
    const PATH = 'test';

    private $filesystem;
    
    private function filesystem() : FilesystemInterface
    {
        if ($this->filesystem == null) {
            $this->filesystem = new Filesystem(new MemoryAdapter());
        }
        return $this->filesystem;
    }

    private function encoder() : PersistableDocumentEncoder
    {
        $encoder = $this->createMock(PersistableDocumentEncoder::class);
        $encoder->method('encode')
            ->will($this->returnCallback(function ($value) {
                return serialize($value);
            }));
        $encoder->method('decode')
            ->will($this->returnCallback(function ($value) {
                return unserialize($value);
            }));
        return $encoder;
    }
    
    public function testOffsetExists()
    {
        $test = new PersistableDocument($this->filesystem(), static::PATH, $this->encoder(), ['key' => 'value']);
        $this->assertTrue($test->offsetExists('key'));
        $this->assertFalse($test->offsetExists('dummy'));
    }

    public function testOffsetGet()
    {
        $test = new PersistableDocument($this->filesystem(), static::PATH, $this->encoder(), ['key' => 'value']);
        $this->assertEquals('value', $test->offsetGet('key'));
    }

    public function testOffsetSet()
    {
        $write = new PersistableDocument($this->filesystem(), static::PATH, $this->encoder(), ['key' => 'value']);
        $write->offsetSet('key2', 'value2');
        $this->assertEquals('value2', $write['key2']);

        $read = new PersistableDocument($this->filesystem(), static::PATH, $this->encoder());
        $this->assertEquals('value', $read['key']);
        $this->assertEquals('value2', $read['key2']);
    }

    public function testOffsetUnset()
    {
        $write = new PersistableDocument($this->filesystem(), static::PATH, $this->encoder(), [
            'setKey' => 'setValue',
            'unsetKey' => 'unsetValue'
        ]);
        $write->offsetUnset('unsetKey');
        $this->assertTrue($write->offsetExists('setKey'));
        $this->assertFalse($write->offsetExists('unsetKey'));

        $read = new PersistableDocument($this->filesystem(), static::PATH, $this->encoder());
        $this->assertEquals('setValue', $read['setKey']);
        $this->assertFalse($read->offsetExists('unsetKey'));
    }
}
