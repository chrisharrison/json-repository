<?php

namespace ChrisHarrison\JsonRepository\Persistence\Encoders;

use PHPUnit\Framework\TestCase;

class JsonEncoderTest extends TestCase
{
    public function testEncodeDecode()
    {
        $test= [
            'key' => 'value'
        ];
        $encoder = new JsonEncoder;
        $output = $encoder->encode($test);
        $this->assertEquals($test, $encoder->decode($output));
    }
}
