<?php

namespace Ruvos\Blog\DomainObject;

interface Event
{
    public static function getTopic(): string;

    public function toJson(): string;
}
