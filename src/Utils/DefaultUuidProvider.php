<?php

namespace Ruvos\Blog\Utils;

use Ramsey\Uuid\Uuid;

final readonly class DefaultUuidProvider implements UuidProvider
{
    public static function v4(): string
    {
        return Uuid::uuid4()->toString();
    }
}