<?php

declare(strict_types=1);

namespace Blog\Tests\Unit\Post;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Ruvos\Blog\DomainObject\AbstractEvent;
use Ruvos\Blog\DomainObject\Content\Event\TextContentCreatedEvent;
use Ruvos\Blog\DomainObject\Content\TextContent;
use Ruvos\Blog\DomainObject\Exception\DomainObjectException;
use Ruvos\Blog\DomainObject\Post\Event\PostCreatedEvent;
use Ruvos\Blog\DomainObject\Post\Event\TextContentAddedEvent;
use Ruvos\Blog\DomainObject\Post\Post;
use Ruvos\Blog\DomainObject\Post\State;
use Ruvos\Blog\Utils\DefaultDateTimeProvider;
use Ruvos\Blog\Utils\DefaultUuidProvider;
use Throwable;

#[CoversClass(Post::class)]
#[UsesClass(AbstractEvent::class)]
#[UsesClass(PostCreatedEvent::class)]
#[UsesClass(DefaultDateTimeProvider::class)]
#[UsesClass(DefaultUuidProvider::class)]
#[UsesClass(TextContent::class)]
#[UsesClass(TextContentCreatedEvent::class)]
#[UsesClass(TextContentAddedEvent::class)]
final class PostTest extends TestCase
{
    public function testCreateNewPostIsValid(): void
    {
        $post = Post::create('New Title');

        $this->assertSame('New Title', $post->getTitle());
        $this->assertCount(1, $post->getEvents());
        $this->assertCount(0, $post->getEvents());
    }

    public function testCreateExistingFromEventsIsValid(): void
    {
        $createdEvent = PostCreatedEvent::create('New Title');
        /** @var Post $post */
        $post = Post::fromEvents([$createdEvent]);

        $this->assertSame([], $post->getEvents());
        $this->assertSame('New Title', $post->getTitle());
        $this->assertSame(State::DRAFT, $post->getState());
    }

    public function testAddTextContentIsValid(): void
    {
        $textContent = TextContent::create('I am Content!');

        $post = Post::create('I am a new Post!');

        $post->addTextContent($textContent);

        $this->assertCount(2, $post->getEvents());
    }

    public function testInvalidEventThrowsException(): void
    {
        $events = [$invalidEvent = TextContentCreatedEvent::create('invalid')];

        $excpectedException = DomainObjectException::unsupportedEvent($invalidEvent);

        try {
            Post::fromEvents($events);
            $this->fail('should throw exception');
        } catch (Throwable $exception) {
            $this->assertSame($excpectedException->getMessage(), $exception->getMessage());
        }
    }
}