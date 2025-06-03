<?php

require __DIR__ . '/../vendor/autoload.php';

\Ruvos\Blog\Kernel::boot();

$container = \Ruvos\Blog\Kernel::getContainer();

echo("Hier entsteht ein Eventsourcing Blog").PHP_EOL;
