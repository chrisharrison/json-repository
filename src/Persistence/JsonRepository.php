<?php

namespace ChrisHarrison\JsonRepository\Persistence;

use League\Flysystem\Filesystem;

class JsonRepository extends ArrayObjectRepository
{
    public function __construct(Filesystem $filesystem, string $path)
    {
        parent::__construct(new PersistableJsonDocument($filesystem, $path));
    }
}