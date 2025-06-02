<?php

namespace Blog\Tests\Integration;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use Ruvos\Blog\Database\SqLiteEventStore;
use Ruvos\Blog\DomainObject\AbstractDomainObject;
use Ruvos\Blog\DomainObject\AbstractEvent;
use Ruvos\Blog\DomainObject\Post\Event\PostCreatedEvent;
use Ruvos\Blog\DomainObject\Post\Post;
use Ruvos\Blog\DomainObject\Post\PostRepository;
use Ruvos\Blog\Utils\DefaultUuidProvider;

#[CoversClass(SqLiteEventStore::class)]
#[UsesClass(Post::class)]
#[UsesClass(PostRepository::class)]
#[UsesClass(AbstractEvent::class)]
#[UsesClass(AbstractDomainObject::class)]
#[UsesClass(PostCreatedEvent::class)]
#[UsesClass(DefaultUuidProvider::class)]
final class SqLiteEventStoreTest extends AbstractIntegrationTestCase
{
    public function testSaveIsValid(): void
    {
        $persister = new SqLiteEventStore('sqlite:events.db');

        $postRepository = new PostRepository($persister);

        $post = Post::create('asd');

        /** @var AbstractEvent[] $events */
        $events = $post->getEvents();

        $persister->save($events[0]);

        $posts = $postRepository->loadAll();



        $this->assertCount(1, $posts);
    }
}