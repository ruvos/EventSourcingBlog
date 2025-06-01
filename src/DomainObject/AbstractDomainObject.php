<?php

declare(strict_types=1);

namespace Ruvos\Blog\DomainObject;

use Ruvos\Blog\DomainObject\Exception\EventException;

/**
 * @infection-ignore-all
 */
abstract class AbstractDomainObject
{
    protected string $correlationId;
    protected \DateTimeInterface $createdAt;
    protected \DateTimeInterface $updatedAt;
    /**
     * @var Event[]
     */
    protected array $events;

    protected function applyEvent(Event $event): void
    {
        throw EventException::missingApplyMethod();
    }

    protected function recordEvent(Event $event): void
    {
        $this->applyEvent($event);
        $this->events[] = $event;
    }
}
