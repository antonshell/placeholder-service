<?php

declare(strict_types=1);

namespace App\Helper;

class PathHelper
{
    public static function getBasePath(): string
    {
        return dirname(__DIR__, 2);
    }

    public static function getWebRootPath(): string
    {
        return dirname(__DIR__, 2) . '/public';
    }
}
