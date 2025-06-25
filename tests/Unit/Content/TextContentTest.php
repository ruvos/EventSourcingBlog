<?php

declare(strict_types=1);

namespace Blog\Tests\Unit\Content;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Ruvos\Blog\DomainObject\AbstractDomainObject;
use Ruvos\Blog\DomainObject\AbstractEvent;
use Ruvos\Blog\DomainObject\Content\Event\TextContentCreatedEvent;
use Ruvos\Blog\DomainObject\Content\TextContent;
use Ruvos\Blog\DomainObject\Exception\DomainObjectException;
use Ruvos\Blog\DomainObject\Post\Event\PostCreatedEvent;
use Ruvos\Blog\Utils\DefaultUuidProvider;
use Throwable;

#[CoversClass(TextContent::class)]
#[UsesClass(AbstractDomainObject::class)]
#[UsesClass(AbstractEvent::class)]
#[UsesClass(TextContentCreatedEvent::class)]
#[UsesClass(DefaultUuidProvider::class)]
#[UsesClass(PostCreatedEvent::class)]
final class TextContentTest extends TestCase
{
    public function testCreateIsValid(): void
    {
        $content = 'asd'; 
        $textContent = TextContent::create($content);
        
        $this->assertCount(1, $textContent->getEvents());
    }

    public  function testApplyInvalidEventThrowsException(): void
    {
        $invalidEvent = PostCreatedEvent::create('title');
        $excpectedException = DomainObjectException::unsupportedEvent($invalidEvent);

        try {
            TextContent::fromEvents([$invalidEvent]);
            $this->fail('Should throw exception');
        } catch (Throwable $exception) {
            $this->assertSame($excpectedException->getMessage(), $exception->getMessage());
        }
    }

}
        
    