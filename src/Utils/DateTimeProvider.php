<?php

namespace Ruvos\Blog\Utils;

interface DateTimeProvider
{
    public static function now(): \DateTimeInterface;
}