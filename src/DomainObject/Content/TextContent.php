<?php

declare(strict_types=1);

namespace Ruvos\Blog\DomainObject\Content;

use Ruvos\Blog\DomainObject\AbstractDomainObject;
use Ruvos\Blog\DomainObject\Content\Event\TextContentCreatedEvent;
use Ruvos\Blog\DomainObject\Event;
use Ruvos\Blog\DomainObject\Exception\DomainObjectException;

final class TextContent extends AbstractDomainObject
{
    private string $content;

    public static function create(string $content): self
    {
        $createdEvent = TextContentCreatedEvent::create($content);

        $that = new self();
        $that->recordEvent($createdEvent);

        return $that;
    }

    protected function applyEvent(Event $event): void
    {
        switch ($event::getTopic()) {
            case TextContentCreatedEvent::getTopic():
                $this->applyTextContentCreatedEvent($event);
                break;
            default:
                throw DomainObjectException::unsupportedEvent($event);
        }
    }

    private function applyTextContentCreatedEvent(TextContentCreatedEvent $event): void
    {
        $this->correlationId = $event->correlationId;
        $this->updatedAt = $event->createdAt;
        $this->createdAt = $event->createdAt;
        $this->content = $event->content;
    }
}
