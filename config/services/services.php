<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\DependencyInjection\Reference;

return static function (ContainerConfigurator $container): void {

    $dbDir = __DIR__.'/../';

    $container->parameters()
        ->set('database.dsn', 'sqlite:'.$dbDir.'events.db')
    ;

    $services = $container->services();
    $services->set(\Ruvos\Blog\Database\SqLiteEventStore::class)
        ->args(['%database.dsn%'])
    ;

    $services->set(\Ruvos\Blog\DomainObject\Post\PostRepository::class)
    ->args([
        new Reference(\Ruvos\Blog\Database\SqLiteEventStore::class)
    ])->public();
};