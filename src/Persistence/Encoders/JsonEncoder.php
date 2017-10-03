<?php

namespace ChrisHarrison\JsonRepository\Persistence\Encoders;

final class JsonEncoder implements PersistableDocumentEncoder
{
    public function encode(array $input) : string
    {
        return json_encode($input, JSON_PRETTY_PRINT);
    }

    public function decode(string $input) : array
    {
        return json_decode($input, true);
    }
}
