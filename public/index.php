<?php

use Ruvos\Blog\DomainObject\Post\PostRepository;
use Ruvos\Blog\DomainObject\Post\Post;
require __DIR__ . '/../vendor/autoload.php';

\Ruvos\Blog\Kernel::boot();

$container = \Ruvos\Blog\Kernel::getContainer();

/** @var PostRepository $postRepository */
$postRepository = $container->get(PostRepository::class);

$posts = $postRepository->loadAll();

/** @var Post $post  */
foreach($posts as $post)
{
    echo($post->getTitle());PHP_EOL;
}