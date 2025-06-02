<?php

namespace Ruvos\Blog\DomainObject;

interface DomainObjectRepository
{
    public function loadAll(): array;

    public function getRelevantDomainObject(): string;
}
