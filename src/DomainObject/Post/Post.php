<?php

declare(strict_types=1);

namespace Ruvos\Blog\DomainObject\Post;

use Ruvos\Blog\DomainObject\AbstractDomainObject;
use Ruvos\Blog\DomainObject\Content\TextContent;
use Ruvos\Blog\DomainObject\Event;
use Ruvos\Blog\DomainObject\Exception\DomainObjectException;
use Ruvos\Blog\DomainObject\Post\Event\PostCreatedEvent;
use Ruvos\Blog\DomainObject\Post\Event\TextContentAddedEvent;

final class Post extends AbstractDomainObject
{
    private string $title;

    private State $state;

    private array $body;

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

    public function getState(): State
    {
        return $this->state;
    }

    protected function applyEvent(Event $event): void
    {
        switch ($event::getTopic()) {
            case PostCreatedEvent::getTopic():
                $this->applyPostCreatedEvent($event);
                break;
            case TextContentAddedEvent::getTopic():
                $this->applyTextContentAddedEvent($event);
                break;
            default:
                throw DomainObjectException::unsupportedEvent($event);
        }
    }

    private function applyPostCreatedEvent(PostCreatedEvent $event): void
    {
        $this->title = $event->title;
        $this->updatedAt = $event->createdAt;
        $this->correlationId = $event->correlationId;
        $this->createdAt = $event->createdAt;
        $this->state = $event->state;
    }

    private function applyTextContentAddedEvent(TextContentAddedEvent $event): void
    {
        $this->updatedAt = $event->createdAt;
        $this->body[] = $event->textContentId;
    }

    public function addTextContent(TextContent $textContent): void
    {
        $addedEvent = TextContentAddedEvent::create($textContent->correlationId, $this->correlationId);

        $this->recordEvent($addedEvent);
    }
}
