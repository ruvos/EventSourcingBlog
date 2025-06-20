<?php

declare(strict_types=1);

namespace Ruvos\Blog\DomainObject\Post\Event;

use DateTimeImmutable;
use Ruvos\Blog\DomainObject\AbstractEvent;
use Ruvos\Blog\DomainObject\Event;
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

    public static function create(string $textContentId, string $correlationId): Event
    {
        $createdAt = DefaultDateTimeProvider::now();
        $eventId = DefaultUuidProvider::v4();

        return new self($eventId, $correlationId, $createdAt, $textContentId);
    }

    public static function fromJson(string $payload): AbstractEvent
    {
        $data = json_decode($payload, true);

        return new self(
            $data['eventId'],
            $data['correlationId'],
            new DateTimeImmutable(
                $data['createdAt']['date'],
                new \DateTimeZone($data['createdAt']['timezone'])
            ),
            $data['textContentId']
        );
    }
}
