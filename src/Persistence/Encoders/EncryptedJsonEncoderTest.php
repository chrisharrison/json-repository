<?php

namespace ChrisHarrison\JsonRepository\Persistence\Encoders;

use Phlib\Encrypt\EncryptorInterface;
use PHPUnit\Framework\TestCase;

class EncryptedJsonEncoderTest extends TestCase
{
    public function testEncodeDecode()
    {
        $encryptor = $this->createMock(EncryptorInterface::class);
        $encryptor->method('encrypt')
            ->will($this->returnCallback(function ($value) {
                return strrev($value);
            }));
        $encryptor->method('decrypt')
            ->will($this->returnCallback(function ($value) {
                return strrev($value);
            }));

        $jsonEncoder = new JsonEncoder;

        $encoder = new EncryptedJsonEncoder(
            $encryptor,
            $jsonEncoder,
            ['key']
        );

        $test= [
            'key' => 'value',
            'doNotEncrypt' => 'value2'
        ];

        $output = $encoder->encode($test);

        $jsonDecodedOutput = $jsonEncoder->decode($output);
        $this->assertEquals('value2', $jsonDecodedOutput['doNotEncrypt']);
        $this->assertEquals(base64_encode(strrev('value')), $jsonDecodedOutput['key']);

        $this->assertEquals($test, $encoder->decode($output));
    }
}
