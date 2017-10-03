<?php

namespace ChrisHarrison\JsonRepository\Repositories;

use League\Flysystem\Adapter\NullAdapter;
use League\Flysystem\Filesystem;
use Phlib\Encrypt\EncryptorInterface;
use PHPUnit\Framework\TestCase;

class EncryptedJsonRepositoryTest extends TestCase
{
    public function testConstruct()
    {
        $encryptor = $this->createMock(EncryptorInterface::class);
        $encryptor->method('encrypt')
            ->will($this->returnArgument(0));
        $encryptor->method('decrypt')
            ->will($this->returnArgument(0));

        $filesystem = new Filesystem(new NullAdapter);
        $test = new EncryptedJsonRepository($filesystem, 'test', $encryptor, null);
        $this->assertInstanceOf(RepositoryInterface::class, $test);
    }
}
