<?php

namespace App\Service\ImageGenerator;

use App\Helper\PathHelper;
use App\Model\ColorRgb;
use App\Model\ImageResponse;

abstract class AbstractRaster implements GeneratorInterface
{
    public function generate(
        int $width,
        int $height,
        ?string $text = null,
        int $textSize,
        string $colorText,
        string $colorBg
    ): ImageResponse {
        // generate image
        $im = imagecreatetruecolor($width, $height);

        // create colors
        $colorText = ColorRgb::fromHex($colorText);
        $colorText = imagecolorallocate($im, $colorText->getRed(), $colorText->getGreen(), $colorText->getBlue());

        $colorBg = ColorRgb::fromHex($colorBg);
        $colorBg = imagecolorallocate($im, $colorBg->getRed(), $colorBg->getGreen(), $colorBg->getBlue());

        // fill image with bg color
        imagefilledrectangle($im, 0, 0, $width - 1, $height - 1, $colorBg);

        //create text
        $angle = 0;
        $font = PathHelper::getBasePath() . '/resources/fonts/ArialRegular.ttf';
        $points = imagettfbbox($textSize, $angle, $font, $text);
        $textWidth = abs($points[2]);
        $textHeight = abs($points[5]);

        $textStartX = $width / 2 - $textWidth / 2;
        $textStartY = $height / 2 + $textHeight / 2;
        imagettftext($im, $textSize, $angle, (int) $textStartX, (int) $textStartY, $colorText, $font, $text);

        $response = $this->createResponse($im);
        imagedestroy($im);

        return $response;
    }

    /**
     * @param resource|\GdImage $image
     * @return ImageResponse
     */
    public abstract function createResponse($image): ImageResponse;

}
