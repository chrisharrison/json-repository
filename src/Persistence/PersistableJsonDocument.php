<?php

namespace ChrisHarrison\JsonRepository\Persistence;

class PersistableJsonDocument extends PersistableDocument
{
    public function encode() : string
    {
        return json_encode($this);
    }

    public static function decode(string $content) : array
    {
        return json_decode($content, true);
    }
}