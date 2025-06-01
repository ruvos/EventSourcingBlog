<?php

namespace Blog\Tests\Unit;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Ruvos\Blog\DomainObject\AbstractDomainObject;
use Ruvos\Blog\DomainObject\Event;
use Ruvos\Blog\DomainObject\Exception\EventException;

#[CoversClass(AbstractDomainObject::class)]
final class AbstractDomainObjectTest extends TestCase
{
    public function testMissingApplyMethodThrowsError(): void
    {
        $this->expectException(EventException::class);

        $domainObject = new class extends AbstractDomainObject {
            public function triggerRecordEvent(Event $event): void
            {
                $this->recordEvent($event);
            }
        };

        $event = $this->createMock(Event::class);
        $domainObject->triggerRecordEvent($event);
    }
}