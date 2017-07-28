<?php

namespace ChrisHarrison\JsonRepository\Collections;

use Collections\Collection;
use ChrisHarrison\JsonRepository\Entities\Entity;

class EntityCollection extends Collection
{
    public function __construct()
    {
        parent::__construct(Entity::class);
    }
}