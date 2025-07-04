<?php

namespace Ruvos\Blog\DomainObject\Exception;

/**
 * @codeCoverageIgnore
 * @infection-ignore-all
 */
final class EventException extends \Exception
{
    public static function missingApplyMethod(): self
    {
        return new self('Missing apply method.');
    }

    public static function missingFromJsonMethod(): self
    {
        return new self('Missing fromJson method');
    }
}
