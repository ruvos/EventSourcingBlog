<?php

declare(strict_types=1);

namespace Blog\Tests\Unit\Post;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Ruvos\Blog\DomainObject\AbstractEvent;
use Ruvos\Blog\DomainObject\Post\Event\PostCreatedEvent;
use Ruvos\Blog\DomainObject\Post\Post;
use Ruvos\Blog\Utils\DefaultDateTimeProvider;
use Ruvos\Blog\Utils\DefaultUuidProvider;

#[CoversClass(Post::class)]
#[UsesClass(AbstractEvent::class)]
#[UsesClass(PostCreatedEvent::class)]
#[UsesClass(DefaultDateTimeProvider::class)]
#[UsesClass(DefaultUuidProvider::class)]
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
        $post = Post::fromEvents([$createdEvent]);

        $this->assertSame([], $post->getEvents());
        $this->assertSame('New Title', $post->getTitle());
    }
}