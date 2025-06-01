<?php

declare(strict_types=1);

namespace Ruvos\Blog\DomainObject\Post;

use Ruvos\Blog\DomainObject\AbstractDomainObject;
use Ruvos\Blog\DomainObject\Event;
use Ruvos\Blog\DomainObject\Post\Event\PostCreatedEvent;

final class Post extends AbstractDomainObject
{
    private string $title;

    public static function create(string $title): self
    {
        $createdEvent = PostCreatedEvent::create($title);

        $that = new self();

        $that->recordEvent($createdEvent);

        return $that;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    protected function applyEvent(Event $event): void
    {
        switch ($event::getTopic()) {
            case PostCreatedEvent::getTopic():
                $this->applyPostCreatedEvent($event);
        }
    }

    private function applyPostCreatedEvent(Event $event): void
    {
        $this->title = $event->title;
        $this->updatedAt = $event->createdAt;
        $this->correlationId = $event->correlationId;
        $this->createdAt = $event->createdAt;
    }
}
