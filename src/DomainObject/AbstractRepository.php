<?php

namespace Ruvos\Blog\DomainObject;

use Exception;
use Ruvos\Blog\Database\EventStore;

abstract class AbstractRepository implements DomainObjectRepository
{
    private array $relevantEvents = [];

    public function __construct(protected readonly EventStore $eventStore)
    {
    }

    protected function sortEvents(array $events): array
    {
        $sortedEvents = [];
        foreach ($events as $event) {
            if ($this->isEventRelevant($event)) {
                $sortedEvents[$event->correlationId][] = $event;
            }
        }

        return $sortedEvents;
    }

    protected function buildDomainObjects(array $postEvents): array
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
        $sortedEvents = $this->sortEvents($events);

        return $this->buildDomainObjects($sortedEvents);
    }

    private function isEventRelevant(AbstractEvent $event)
    {
        return in_array($event::class, $this->relevantEvents);
    }

    protected function setRelevantEvents(array $events): void
    {
        $this->relevantEvents = $events;
    }
}
