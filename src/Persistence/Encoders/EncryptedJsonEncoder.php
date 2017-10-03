<?php

namespace ChrisHarrison\JsonRepository\Persistence\Encoders;

use Phlib\Encrypt\EncryptorInterface;

class EncryptedJsonEncoder implements PersistableDocumentEncoder
{
    private $encryptor;
    private $jsonEncoder;
    private $keysToEncrypt; /* If keysToEncrypt is null, then all keys will be encrypted */

    public function __construct(EncryptorInterface $encryptor, JsonEncoder $jsonEncoder, ?array $keysToEncrypt = null)
    {
        $this->encryptor = $encryptor;
        $this->jsonEncoder = $jsonEncoder;
        $this->keysToEncrypt = $keysToEncrypt;
    }

    public function encode(array $input) : string
    {
        $encrypted = $this->iterateKeys($input, function ($value) {
            return $this->encryptor->encrypt($value);
        });
        return $this->jsonEncoder->encode($encrypted);
    }

    public function decode(string $input) : array
    {
        $decoded = $this->jsonEncoder->decode($input);
        return $this->iterateKeys($decoded, function ($value) {
            return $this->encryptor->decrypt($value);
        });
    }

    private function iterateKeys(array $array, callable $iterator)
    {
        foreach ($array as $key => $value) {
            if ($this->keysToEncrypt !== null && !in_array($key, $this->keysToEncrypt)) {
                //Don't call iterator
                continue;
            }
            $array[$key] = $iterator($value);
        }
        return $array;
    }
}
