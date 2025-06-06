<?php

declare(strict_types=1);

namespace Blog\Tests\Unit\Post\Event;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Ruvos\Blog\DomainObject\Post\Event\PostCreatedEvent;
use Ruvos\Blog\Utils\DefaultDateTimeProvider;
use Ruvos\Blog\Utils\DefaultUuidProvider;

#[CoversClass(PostCreatedEvent::class)]
#[UsesClass(DefaultUuidProvider::class)]
#[UsesClass(DefaultDateTimeProvider::class)]
final class PostCreatedEventTest extends TestCase
{
    public function testCreateIsValid(): void
    {
        $event = PostCreatedEvent::create('New Title');

        $this->assertSame('New Title', $event->title);;
    }

    public function testTopicIsCorrect(): void
    {
        $this->assertSame('post.created',PostCreatedEvent::getTopic());
    }

    public function testTitleIsCorrectSet(): void
    {
        $event = PostCreatedEvent::create('New Title');

        $this->assertSame('New Title', $event->title);
    }

    public function testCreatedAtIsValid(): void
    {
        $event = PostCreatedEvent::create('New Title');
        $this->assertInstanceOf(\DateTimeInterface::class, $event->createdAt);

        $now = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));

        $this->assertSame(
            $now->format('Y-m-d H:i:s'),
            $event->createdAt->format('Y-m-d H:i:s')
        );
    }

    public function testToJsonIsValid(): void
    {
        $event = PostCreatedEvent::create('New Title');
        $this->assertJson($event->toJson());
    }

    public function testFromJsonIsValid(): void
    {
        $event = PostCreatedEvent::create('New Title');
        $this->assertInstanceOf(PostCreatedEvent::class, PostCreatedEvent::fromJson($event->toJson()));
    }
}