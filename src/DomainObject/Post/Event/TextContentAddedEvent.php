<?php

declare(strict_types=1);

namespace Ruvos\Blog\DomainObject\Post\Event;

use Ruvos\Blog\DomainObject\AbstractEvent;
use Ruvos\Blog\DomainObject\Event;
use Ruvos\Blog\DomainObject\Post\State;
use Ruvos\Blog\Utils\DefaultDateTimeProvider;
use Ruvos\Blog\Utils\DefaultUuidProvider;

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

    public static function create(string $textContentId): Event
    {
        $createdAt = DefaultDateTimeProvider::now();
        $correlationId = DefaultUuidProvider::v4();
        $eventId = DefaultUuidProvider::v4();

        return new self($eventId, $correlationId, $createdAt, $textContentId);
    }
}
