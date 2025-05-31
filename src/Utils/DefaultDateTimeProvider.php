<?php

namespace Ruvos\Blog\Utils;

final readonly class DefaultDateTimeProvider implements DateTimeProvider
{
    public static function now(): \DateTimeInterface
    {
        return new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
    }
}