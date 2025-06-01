<?php

namespace Ruvos\Blog\Utils;

/**
 * @codeCoverageIgnore
 * @infection-ignore-all
 */
final readonly class DefaultDateTimeProvider implements DateTimeProvider
{
    public static function now(): \DateTimeInterface
    {
        return new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
    }
}
