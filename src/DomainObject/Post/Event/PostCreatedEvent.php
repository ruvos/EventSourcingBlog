<?php

declare(strict_types=1);

namespace Ruvos\Blog\DomainObject\Post\Event;

use DateTimeImmutable;
use Ruvos\Blog\DomainObject\AbstractEvent;
use Ruvos\Blog\DomainObject\Event;
use Ruvos\Blog\Utils\DefaultDateTimeProvider;
use Ruvos\Blog\Utils\DefaultUuidProvider;

final readonly class PostCreatedEvent extends AbstractEvent
{
    private const string TOPIC = 'post.created';
    public static function getTopic(): string
    {
        return self::TOPIC;
    }

    private function __construct(
        string $eventId,
        string $correlationId,
        \DateTimeInterface $createdAt,
        public string $title
    ) {
        parent::__construct($correlationId, $eventId, $createdAt);
    }

    public static function create(string $title): Event
    {
        $createdAt = DefaultDateTimeProvider::now();
        $correlationId = DefaultUuidProvider::v4();
        $eventId = DefaultUuidProvider::v4();

        return new self($eventId, $correlationId, $createdAt, $title);
    }

    public static function fromJson(string $payload)
    {
        $data = json_decode($payload, true, 512, JSON_THROW_ON_ERROR);
        return new self(
            $data['eventId'],
            $data['correlationId'],
            new DateTimeImmutable($data['createdAt']['date'], new \DateTimeZone($data['createdAt']['timezone'])),
            $data['title']
        );
    }

    public function toJson(): string
    {
        return json_encode($this, JSON_THROW_ON_ERROR);
    }
}
