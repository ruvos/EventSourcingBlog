<?php

declare(strict_types=1);

namespace Ruvos\Blog\DomainObject;

abstract readonly class AbstractEvent implements Event
{
    protected function __construct(
        public string $correlationId,
        public string $eventId,
        public \DateTimeInterface $createdAt
    ) {
    }
}
