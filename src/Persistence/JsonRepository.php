<?php

namespace ChrisHarrison\JsonRepository\Persistence;

class JsonRepository extends ArrayObjectRepository
{
    public function __construct(string $path)
    {
        parent::__construct(new PersistableJsonDocument($path));
    }
}