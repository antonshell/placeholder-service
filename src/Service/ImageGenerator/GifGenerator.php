<?php

namespace App\Service\ImageGenerator;

use App\Model\ImageResponse;

class GifGenerator extends AbstractRaster
{
    /**
     * @inheritDoc
     */
    public function createResponse($image): ImageResponse {
        if (!$path = tempnam(sys_get_temp_dir(), 'img-')) {
            throw new \RuntimeException('Cannot allocate temporary file.');
        }

        if (!imagegif($image, $path)) {
            throw new \RuntimeException('Cannot write image to destination.');
        }

        return new ImageResponse(
            'image/gif',
            filesize($path),
            $path,
            'image.gif'
        );
    }
}
