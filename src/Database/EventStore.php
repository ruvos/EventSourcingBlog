<?php

namespace Ruvos\Blog\Database;

use Ruvos\Blog\DomainObject\AbstractEvent;

interface EventStore
{
    public function save(AbstractEvent $event): void;

    /** @return AbstractEvent[] */
    public function loadAll(): array;
}
