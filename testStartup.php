<?php

use Ruvos\Blog\Database\SqLiteEventStore;
use Ruvos\Blog\DomainObject\Content\Event\TextContentCreatedEvent;
use Ruvos\Blog\DomainObject\Post\Event\PostCreatedEvent;
use Ruvos\Blog\DomainObject\Post\Event\TextContentAddedEvent;
use Ruvos\Blog\DomainObject\Post\PostRepository;

require __DIR__ . '/vendor/autoload.php';

\Ruvos\Blog\Kernel::boot();

$container = \Ruvos\Blog\Kernel::getContainer();

$dbDir = __DIR__.'/config/';

$dbLocation = sprintf('sqlite:%sevents.db', $dbDir);

if(is_file($dbLocation)) {
    unlink($dbLocation);
}

$persister = new SqLiteEventStore($dbLocation);

$postRepository = new PostRepository($persister);


$postCreatedEvent = PostCreatedEvent::create('Test');
$textContentCreatedEvent = TextContentCreatedEvent::create('textContent');
$textContentAddedEvent = TextContentAddedEvent::create($textContentCreatedEvent->correlationId, $postCreatedEvent->correlationId);

$events = [$postCreatedEvent, $textContentCreatedEvent, $textContentAddedEvent];

foreach($events as $event) {
    $persister->save($event);
}
