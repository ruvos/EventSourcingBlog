<?php 

namespace Blog\Tests\Unit\Post\Mock;

use Ruvos\Blog\Database\EventStore;
use Ruvos\Blog\DomainObject\AbstractEvent;

class EventStoreMock implements EventStore
{
      public array $events = [];

      public function loadAll(): array
      {
            return $this->events;
      }

      public function save(AbstractEvent $event): void
      {

      }
}
