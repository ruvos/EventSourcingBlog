<?php

declare(strict_types=1);

namespace Ruvos\Blog\DomainObject\Post;

use Ruvos\Blog\DomainObject\AbstractRepository;
use Ruvos\Blog\DomainObject\DomainObjectRepository;

final readonly class PostRepository extends AbstractRepository implements DomainObjectRepository
{
    public function getRelevantDomainObject(): string
    {
        return Post::class;
    }
}
