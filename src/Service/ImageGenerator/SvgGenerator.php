<?php

namespace App\Service\ImageGenerator;

use App\Model\ImageResponse;

class SvgGenerator implements GeneratorInterface
{
    public function generate(
        int $width,
        int $height,
        ?string $text = null,
        int $textSize,
        string $colorText,
        string $colorBg
    ): ImageResponse {
        $textStartX = $width / 2;
        $textStartY = $height / 2;

        $colorText = is_numeric($colorText) ? "#$colorText" : $colorText;
        $colorBg = is_numeric($colorBg) ? "#$colorBg" : $colorBg;

        $xml = <<<EOXML
<?xml version="1.0" encoding="utf-8"?>
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
    width="$width"
    height="$height"
    >
    <rect x="0" y="0" width="100%" height="100%" style="fill: $colorBg"/>
    <text x="$textStartX" y="$textStartY"
        text-anchor="middle"
        font-family="Arial,Sans"
        font-size="$textSize"
        fill="$colorText">
        $text
  </text>
</svg>
EOXML;

        if (!$path = tempnam(sys_get_temp_dir(), 'img-')) {
            throw new \RuntimeException('Cannot allocate temporary file.');
        }

        if (!file_put_contents($path, $xml)) {
            throw new \RuntimeException('Cannot write image to destination.');
        }

        return new ImageResponse(
            'image/svg+xml',
            filesize($path),
            $path,
            'image.svg'
        );
    }
}
