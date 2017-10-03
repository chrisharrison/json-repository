<?php

namespace ChrisHarrison\JsonRepository\Persistence\Encoders;

interface PersistableDocumentEncoder
{
    public function encode(array $input) : string;
    public function decode(string $input) : array;
}
