<?php

namespace App\Service;

class PlaceholderGenerator
{
    const COLOR_WHITE = 'fff';
    const COLOR_GREY = 'aaa';

    const DEFAULT_TEXT_SIZE = 28;

    public function generate(
        int $width,
        int $height,
        ?string $text = null,
        int $textSize = self::DEFAULT_TEXT_SIZE,
        string $colorText = self::COLOR_WHITE,
        string $colorBg = self::COLOR_GREY
    ): void {
        if($text === null) {
            $text = sprintf('%sx%s', $width, $height);
        }

        header('Content-type: image/png');

        // generate image
        $im = imagecreatetruecolor($width, $height);

        // create colors
        $white = imagecolorallocate($im, 255, 255, 255);
        $grey = imagecolorallocate($im, 128, 128, 128);

        // fill image with bg color
        imagefilledrectangle($im, 0, 0, $width - 1, $height - 1, $grey);

        //create text
        $angle = 0;
        $font = __DIR__ . '/../../resources/fonts/ArialRegular.ttf';
        $points = imagettfbbox($textSize, $angle, $font, $text);
        $textWidth = abs($points[2]);
        $textHeight = abs($points[5]);

        $textStartX = $width / 2 - $textWidth / 2;
        $textStartY = $height / 2 + $textHeight / 2;
        imagettftext($im, $textSize, $angle, $textStartX, $textStartY, $white, $font, $text);

        // create image
        imagepng($im);
        imagedestroy($im);
        exit;
    }
}
