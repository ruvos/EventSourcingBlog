<?php

declare(strict_types=1);

namespace Ruvos\Blog\DomainObject\Post;

use Ruvos\Blog\DomainObject\AbstractDomainObject;

final class Post extends AbstractDomainObject
{
    private string $title;
}
