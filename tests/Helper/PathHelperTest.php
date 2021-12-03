<?php

declare(strict_types=1);

namespace App\Tests\Helper;

use App\Helper\PathHelper;
use PHPUnit\Framework\TestCase;

class PathHelperTest extends TestCase
{
    public function testGetBasePath(): void
    {
        self::assertEquals(dirname(__DIR__, 2), PathHelper::getBasePath());
    }

    public function testGetWebRootPath(): void
    {
        self::assertEquals(dirname(__DIR__, 2) . '/public', PathHelper::getWebRootPath());
    }
}
