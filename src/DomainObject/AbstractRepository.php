<?php

namespace Ruvos\Blog\DomainObject;

use Ruvos\Blog\Database\EventStore;

abstract readonly class AbstractRepository implements DomainObjectRepository
{
    public function __construct(protected EventStore $eventStore)
    {
    }

    protected function sortEvents(array $events): array
    {
        $sortedEvents = [];

        foreach ($events as $event) {
            $sortedEvents[$event->correlationId][] = $event;
        }

        return $sortedEvents;
    }

    protected function buildPostsFromEvents(array $postEvents): array
    {
        $posts = [];

        foreach ($postEvents as $events) {
            $posts[] = $this->getRelevantDomainObject()::fromEvents($events);
        }

        return $posts;
    }

    public function loadAll(): array
    {
        $events = $this->eventStore->loadAll();
        $posts = $this->sortEvents($events);

        return $this->buildPostsFromEvents($posts);
    }
}
