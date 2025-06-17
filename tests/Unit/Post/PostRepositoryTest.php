<?php

namespace Blog\Tests\Unit\Post;

use Blog\Tests\Unit\Post\Mock\EventStoreMock;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PhpUnit\Framework\TestCase;
use Ruvos\Blog\DomainObject\AbstractDomainObject;
use Ruvos\Blog\DomainObject\AbstractEvent;
use Ruvos\Blog\DomainObject\Post\Event\PostCreatedEvent;
use Ruvos\Blog\DomainObject\Post\PostRepository;
use Ruvos\Blog\DomainObject\Post\Post;
use Ruvos\Blog\Utils\DefaultUuidProvider;

#[CoversClass(PostRepository::class)]
#[UsesClass(AbstractDomainObject::class)]
#[UsesClass(AbstractEvent::class)]
#[UsesClass(PostCreatedEvent::class)]
#[UsesClass(Post::class)]
#[UsesClass(DefaultUuidProvider::class)]
final class PostRepositoryTest extends TestCase
{

	private EventStoreMock $eventStoreMock;
	private PostRepository $postRepository;

	protected function setUp(): void
	{
		$this->eventStoreMock = new EventStoreMock();
		$this->postRepository = new PostRepository($this->eventStoreMock);
	}

	public function testPostRepositoryHasCorrectClass(): void
	{
		$this->assertSame(Post::class, $this->postRepository->getRelevantDomainObject()); 
	}

	public function testLoadAllReturns2Posts(): void
	{
		$createdFirstPostEvent = PostCreatedEvent::create('firstPost');
		$createdSecondPostEvent = PostCreatedEvent::create('secondPost');

		$this->eventStoreMock->events = [$createdFirstPostEvent, $createdSecondPostEvent];

		$posts = $this->postRepository->loadAll();
		$this->assertCount(2, $posts);

		$this->assertInstanceOf(Post::class, $posts[0]);
		$this->assertInstanceOf(Post::class, $posts[1]);
	}
}
