<?php

declare(strict_types=1);

namespace Ruvos\Blog\DomainObject\Post\Event;

use Ruvos\Blog\DomainObject\AbstractEvent;

final readonly class TextContentAddedEvent extends AbstractEvent
{
    private const string TOPIC = 'textcontent.added';

    public static function getTopic(): string
    {
        return self::TOPIC;
    }

    private function __construct(
        string $eventId,
        string $correlationId,
        \DateTimeInterface $createdAt,
        public string $textContentId
        ) {
        parent::__construct($correlationId, $eventId, $createdAt);
    }
}