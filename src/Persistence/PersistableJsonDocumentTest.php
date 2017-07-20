<?php

namespace ChrisHarrison\JsonRepository\Persistence;

use PHPUnit\Framework\TestCase;

class PersistableJsonDocumentTest extends TestCase
{
    const PATH = __DIR__ . '/../../test/test.json';

    public function setUp()
    {
        if (file_exists(static::PATH)) {
            unlink(static::PATH);
        }
    }

    public function tearDown()
    {
        if (file_exists(static::PATH)) {
            unlink(static::PATH);
        }
    }

    public function testOffsetExists()
    {
        $test = new PersistableJsonDocument(static::PATH, ['key' => 'value']);
        $this->assertTrue($test->offsetExists('key'));
        $this->assertFalse($test->offsetExists('dummy'));
    }

    public function testOffsetGet()
    {
        $test = new PersistableJsonDocument(static::PATH, ['key' => 'value']);
        $this->assertEquals('value', $test->offsetGet('key'));
    }

    public function testOffsetSet()
    {
        $write = new PersistableJsonDocument(static::PATH, ['key' => 'value']);
        $write->offsetSet('key2', 'value2');
        $this->assertEquals('value2', $write['key2']);

        $read = new PersistableJsonDocument(static::PATH);
        $this->assertEquals('value', $read['key']);
        $this->assertEquals('value2', $read['key2']);
    }

    public function testOffsetUnset()
    {
        $write = new PersistableJsonDocument(static::PATH, [
            'setKey' => 'setValue',
            'unsetKey' => 'unsetValue'
        ]);
        $write->offsetUnset('unsetKey');
        $this->assertTrue($write->offsetExists('setKey'));
        $this->assertFalse($write->offsetExists('unsetKey'));

        $read = new PersistableJsonDocument(static::PATH);
        $this->assertEquals('setValue', $read['setKey']);
        $this->assertFalse($read->offsetExists('unsetKey'));
    }
}