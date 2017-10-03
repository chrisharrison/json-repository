<?php

namespace ChrisHarrison\JsonRepository\Collections;

use PHPUnit\Framework\TestCase;

class EntityCollectionTest extends TestCase
{
    public function testConstruct()
    {
        $test = new EntityCollection;
        $this->assertInstanceOf(EntityCollection::class, $test);
    }
}
