<?php

declare(strict_types=1);

namespace Ruvos\Blog\DomainObject;

abstract class AbstractDomainObject
{
    protected string $correlationId;
    protected \DateTimeInterface $createdAt;
    protected \DateTimeInterface $updatedAt;
    /**
     * @var Event[]
     */
    protected array $events;
}
