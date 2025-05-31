<?php

namespace Ruvos\Blog\Utils;

interface UuidProvider
{
    public static function v4(): string;
}