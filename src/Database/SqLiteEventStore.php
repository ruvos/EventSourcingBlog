<?php

namespace Ruvos\Blog\Database;

use Ruvos\Blog\DomainObject\AbstractEvent;
use Ruvos\Blog\DomainObject\Content\Event\TextContentCreatedEvent;
use Ruvos\Blog\DomainObject\Post\Event\PostCreatedEvent;
use Ruvos\Blog\DomainObject\Post\Event\TextContentAddedEvent;

final class SqLiteEventStore implements EventStore
{
    private ?\PDO $pdo = null;

    public function __construct(private string $dsn)
    {
    }

    private function getConnection(): \PDO
    {
        if (null === $this->pdo) {
            $this->pdo = new \PDO($this->dsn);

            $this->createSchema();
        }
        return $this->pdo;
    }

    public function save(AbstractEvent $event): void
    {
        $payload = $event->toJson();

        $connection = $this->getConnection();
        $connection->beginTransaction();

        $statement = $connection->prepare('
INSERT INTO events (
                    eventId,
                    correlationId,
                    topic,
                    createdAt,
                    payload
                    ) VALUES (
                              :eventId,
                              :correlationId,
                              :topic,
                              :createdAt,
                              :payload
                              )
                              ');
        $statement->execute(
            [
                ':eventId' => $event->eventId,
                ':correlationId' => $event->correlationId,
                ':topic' => $event->getTopic(),
                ':createdAt' => $event->createdAt->format('Y-m-d H:i:s.u'),
                ':payload' => $payload
            ]
        );

        $connection->commit();
    }

    private function createSchema(): void
    {
        $this->pdo->exec('
        CREATE TABLE IF NOT EXISTS events (
            eventId VARCHAR(36) PRIMARY KEY,
            correlationId VARCHAR(36),
            topic TEXT,
            createdAt TEXT,
            payload LONGTEXT
        )');

        $this->pdo->exec('CREATE INDEX IF NOT EXISTS idx_correlation_id ON events (correlationId)');
        $this->pdo->exec('CREATE INDEX IF NOT EXISTS idx_topic ON events (topic)');
    }

    public function loadAll(): array
    {
        $this->getConnection();

        $statement = $this->pdo->prepare('SELECT * FROM events');

        $statement->execute();
        $eventsArray = $statement->fetchAll(\PDO::FETCH_NAMED);

        $events = [];

        foreach ($eventsArray as $eventArray) {
            switch ($eventArray['topic']) {
                case PostCreatedEvent::getTopic():
                    $events[] = PostCreatedEvent::fromJson($eventArray['payload']);
                    break;
                case TextContentAddedEvent::getTopic():
                    $events[] = TextContentAddedEvent::fromJson($eventArray['payload']);
                    break;
                case TextContentCreatedEvent::getTopic():
                    $events[] = TextContentCreatedEvent::fromJson($eventArray['payload']);
                    break;
            }
        }

        return $events;
    }
}
