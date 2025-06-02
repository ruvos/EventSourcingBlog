<?php

namespace Blog\Tests\Integration;

use PHPUnit\Framework\TestCase;

abstract class AbstractIntegrationTestCase extends TestCase
{

    protected function setUp(): void
    {
        unlink(__DIR__.'/../../dev-tools/events.db');
    }
    protected function tearDown(): void
    {
        unlink(__DIR__.'/../../dev-tools/events.db');
    }
}