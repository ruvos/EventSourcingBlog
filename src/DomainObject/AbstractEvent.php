<?php

declare(strict_types=1);

namespace Ruvos\Blog\DomainObject;

use Ruvos\Blog\DomainObject\Exception\EventException;

abstract readonly class AbstractEvent implements Event
{
    protected function __construct(
        public string $correlationId,
        public string $eventId,
        public \DateTimeInterface $createdAt
    ) {
    }

    public function toJson(): string
    {
        return json_encode($this, JSON_THROW_ON_ERROR);
    }

    public static function fromJson(string $payload): self
    {
        throw EventException::missingFromJsonMethod();
    }
}
