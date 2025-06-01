<?php

namespace Blog\Tests\Unit\Utils;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Ruvos\Blog\Utils\DefaultUuidProvider;

#[CoversClass(DefaultUuidProvider::class)]
final class DefaultUuidProviderTest extends TestCase
{
    public function testUuidIsValid(): void
    {
        $uuid = DefaultUuidProvider::v4();

        $this->assertSame(36, strlen($uuid));
    }
}