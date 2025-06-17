<?php

namespace Ruvos\Blog;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

/**
 * @codeCoverageIgnore
 **/
final class Kernel
{
    private static Container $container;

    public static function boot(): void
    {
        $container = new ContainerBuilder();

        $rootDir = dirname(__DIR__ . '../');
        $configDir = $rootDir . '/config/services/';

        $loader = new PhpFileLoader($container, new FileLocator($configDir));
        $loader->load('services.php');

        $container->compile();

        self::$container = $container;
    }



    public static function getContainer(): Container
    {
        return self::$container;
    }
}
