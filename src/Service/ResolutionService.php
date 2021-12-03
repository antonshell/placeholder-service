<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Resolution;
use App\Request\ImageRequest;

class ResolutionService
{
    public const DEFAULT_WIDTH = 300;
    public const DEFAULT_HEIGHT = 300;

    public function createFromRequest(ImageRequest $request): Resolution
    {
        $width = $request->getWidth();
        $height = $request->getHeight();

        if (!$width && !$height) {
            $width = self::DEFAULT_WIDTH;
            $height = self::DEFAULT_HEIGHT;
        }

        if ($width && !$height) {
            $height = $width;
        }

        if ($height && !$width) {
            $width = $height;
        }

        return new Resolution($width, $height);
    }
}
