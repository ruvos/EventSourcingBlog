<?php

declare(strict_types=1);

namespace Ruvos\Blog\DomainObject\Content\Event;

use DateTimeImmutable;
use Ruvos\Blog\DomainObject\AbstractEvent;
use Ruvos\Blog\Utils\DefaultDateTimeProvider;
use Ruvos\Blog\Utils\DefaultUuidProvider;

final readonly class TextContentCreatedEvent extends AbstractEvent
{
    private const string EVENT_NAME = 'content.created';

    public static function getTopic(): string
    {
        return self::EVENT_NAME;
    }

    private function __construct(
        string $eventId,
        string $correlationId,
        \DateTimeInterface $createdAt,
        public string $content
    ) {
        parent::__construct($correlationId, $eventId, $createdAt);
    }


    public static function create(string $content): self
    {
        $createdAt = DefaultDateTimeProvider::now();
        $correlationId = DefaultUuidProvider::v4();
        $eventId = DefaultUuidProvider::v4();

        return new self($eventId, $correlationId, $createdAt, $content);
    }

    public static function fromJson(string $payload): AbstractEvent
    {
        $data = json_decode($payload, true);

        return new self(
            $data['eventId'],
            $data['correlationId'],
            new DateTimeImmutable($data['createdAt']['date'], new \DateTimeZone($data['createdAt']['timezone'])),
            $data['content']
        );
    }
}
