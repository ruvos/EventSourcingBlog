<?php

declare(strict_types=1);

namespace Ruvos\Blog\DomainObject\Post;

enum State: string
{
    case DRAFT = 'draft';
}
