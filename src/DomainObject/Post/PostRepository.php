<?php

declare(strict_types=1);

namespace Ruvos\Blog\DomainObject\Post;

use Ruvos\Blog\Database\EventStore;
use Ruvos\Blog\DomainObject\AbstractRepository;
use Ruvos\Blog\DomainObject\DomainObjectRepository;
use Ruvos\Blog\DomainObject\Post\Event\PostCreatedEvent;
use Ruvos\Blog\DomainObject\Post\Event\TextContentAddedEvent;

final class PostRepository extends AbstractRepository implements DomainObjectRepository
{
    public function __construct(EventStore $eventStore)
    {
        parent::__construct($eventStore);
        $this->setRelevantEvents(
            [
                PostCreatedEvent::class,
                TextContentAddedEvent::class
            ]
        );
    }

    public function getRelevantDomainObject(): string
    {
        return Post::class;
    }
}
