<?php

declare(strict_types=1);

namespace Ruvos\Blog\DomainObject\Exception;

use Ruvos\Blog\DomainObject\Event;

/**
 * @infection-ignore-all
 * @codeCoverageIgnore
 */
final class DomainObjectException extends \Exception
{
    public static function unsupportedEvent(Event $event): self
    {
        return new self(sprintf('Event "%s" is not supported.', get_class($event),));
    }
}
