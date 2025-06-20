<?php

declare(strict_types=1);

namespace Blog\Tests\Unit\Content\Event;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Ruvos\Blog\DomainObject\Content\Event\TextContentCreatedEvent;
use Ruvos\Blog\Utils\DefaultUuidProvider;

#[CoversClass(TextContentCreatedEvent::class)]
#[UsesClass(DefaultUuidProvider::class)]
final class TextContentCreatedEventTest extends TestCase
{
    public function testCreateTextContentCreatedEventIsValid(): void
    {
        $event = TextContentCreatedEvent::create('content');

        $this->assertSame('content', $event->content);
    }

    public function testTopicNameIsValid(): void
    {
        $this->assertSame('content.created', TextContentCreatedEvent::getTopic());
    }
}