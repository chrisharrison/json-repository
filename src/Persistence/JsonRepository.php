<?php

namespace ChrisHarrison\JsonRepository\Persistence;

class JsonRepository extends ArrayAccessRepository
{
    public function __construct(string $path)
    {
        parent::__construct(new PersistableJsonDocument($path));
    }
}