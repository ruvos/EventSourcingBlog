<?php

namespace Blog\Tests\Unit\Post;

use Blog\Tests\Unit\Post\Mock\EventStoreMock;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PhpUnit\Framework\TestCase;
use Ruvos\Blog\Database\EventStore;
use Ruvos\Blog\DomainObject\Post\PostRepository;
use Ruvos\Blog\DomainObject\Post\Post;

#[CoversClass(PostRepository::class)]
final class PostRepositoryTest extends TestCase
{

	private EventStore $eventStoreMock;

	protected function setUp(): void
	{
		$this->eventStoreMock = new EventStoreMock();
	}

	public function testPostRepositoryHasCorrectClass(): void
	{
		$repository = new PostRepository($this->eventStoreMock);

		$this->assertSame(Post::class, $repository->getRelevantDomainObject()); 
	}
}
