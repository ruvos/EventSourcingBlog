<?php 

namespace Blog\Tests\Unit\Post\Mock;

use Ruvos\Blog\Database\EventStore;
use Ruvos\Blog\DomainObject\AbstractEvent;

class EventStoreMock implements EventStore
{
      public function loadAll(): array
      {
            return [];
      }

      public function save(AbstractEvent $event): void
      {

      }
}
