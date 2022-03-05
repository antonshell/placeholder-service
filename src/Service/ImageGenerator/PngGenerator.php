<?php

namespace App\Service\ImageGenerator;

use App\Model\ImageResponse;

class PngGenerator extends AbstractRaster
{
    /**
     * @inheritDoc
     */
    public function createResponse($image): ImageResponse {
        if (!$path = tempnam(sys_get_temp_dir(), 'img-')) {
            throw new \RuntimeException('Cannot allocate temporary file.');
        }

        if (!imagepng($image, $path)) {
            throw new \RuntimeException('Cannot write image to destination.');
        }

        return new ImageResponse(
            'image/png',
            filesize($path),
            $path,
            'image.png'
        );
    }
}
