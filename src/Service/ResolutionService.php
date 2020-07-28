<?php

namespace App\Service;

use App\Model\Resolution;
use Symfony\Component\HttpFoundation\Request;

class ResolutionService
{
    const DEFAULT_WIDTH = 300;
    const DEFAULT_HEIGHT = 300;

    public function createFromRequest(Request $request): Resolution
    {
        $width = $request->get('width');
        $height = $request->get('height');

        if(!$width && !$height) {
            $width = self::DEFAULT_WIDTH;
            $height = self::DEFAULT_HEIGHT;
        }

        if($width && !$height) {
            $height = $width;
        }

        if($height && !$width) {
            $width = $height;
        }

        $resolution = new Resolution();
        $resolution
            ->setWidth((int) $width)
            ->setHeight((int) $height);

        return $resolution;
    }
}
