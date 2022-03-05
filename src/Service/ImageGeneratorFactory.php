<?php

namespace App\Service;

use App\Service\ImageGenerator\GeneratorInterface;
use App\Service\ImageGenerator\GifGenerator;
use App\Service\ImageGenerator\JpegGenerator;
use App\Service\ImageGenerator\PngGenerator;
use App\Service\ImageGenerator\SvgGenerator;

class ImageGeneratorFactory
{
    public function create(?string $format): GeneratorInterface {
        switch ($format) {
            case 'svg':
                return new SvgGenerator();

            case 'jpg':
            case 'jpeg':
                return new JpegGenerator();

            case 'gif':
                return new GifGenerator();

            case 'png':
                return new PngGenerator();

            default:
                throw new \Exception('Unsupported format. Try PNG instead.');
        }
    }
}
