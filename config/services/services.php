<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $container): void {
    $container->parameters()
        ->set('database.dsn', 'sqlite:./../events.db')
    ;

    $services = $container->services();
    $services->set(\Ruvos\Blog\Database\SqLiteEventStore::class)
        ->args(['%database.dsn%'])
    ;
};