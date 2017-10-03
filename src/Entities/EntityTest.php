<?php

namespace ChrisHarrison\JsonRepository\Entities;

use PHPUnit\Framework\TestCase;

class EntityTest extends TestCase
{
    public function testConstruct()
    {
        $test = new Entity('id', ['key' => 'value']);
        $this->assertInstanceOf(Entity::class, $test);
    }

    public function testGetId()
    {
        $test = new Entity('id', ['key' => 'value']);
        $this->assertEquals('id', $test->getId());
    }

    public function testGetProperty()
    {
        $test = new Entity('id', ['key' => 'value']);
        $this->assertEquals('value', $test->getProperty('key'));
    }

    public function testGetProperties()
    {
        $properties = ['key' => 'value'];
        $test = new Entity('id', $properties);
        $this->assertEquals($properties, $test->getProperties());
    }
}
