<?php

namespace App\Service;

use App\Model\ColorRgb;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class PlaceholderGenerator
{
    const COLOR_WHITE = 'fff';
    const COLOR_GREY = '888';

    const DEFAULT_TEXT_SIZE = 28;

    public function generate(
        int $width,
        int $height,
        ?string $text = null,
        int $textSize = self::DEFAULT_TEXT_SIZE,
        string $colorText = self::COLOR_WHITE,
        string $colorBg = self::COLOR_GREY
    ): Response {
        if($text === null) {
            $text = sprintf('%sx%s', $width, $height);
        }

        // generate image
        $im = imagecreatetruecolor($width, $height);

        // create colors
        $colorText = $this->hex2rgb($colorText);
        $colorText = imagecolorallocate($im, $colorText->getRed(), $colorText->getGreen(), $colorText->getBlue());

        $colorBg = $this->hex2rgb($colorBg);
        $colorBg = imagecolorallocate($im, $colorBg->getRed(), $colorBg->getGreen(), $colorBg->getBlue());

        // fill image with bg color
        imagefilledrectangle($im, 0, 0, $width - 1, $height - 1, $colorBg);

        //create text
        $angle = 0;
        $font = __DIR__ . '/../../resources/fonts/ArialRegular.ttf';
        $points = imagettfbbox($textSize, $angle, $font, $text);
        $textWidth = abs($points[2]);
        $textHeight = abs($points[5]);

        $textStartX = $width / 2 - $textWidth / 2;
        $textStartY = $height / 2 + $textHeight / 2;
        imagettftext($im, $textSize, $angle, $textStartX, $textStartY, $colorText, $font, $text);

        // create image - old version
        /*header('Content-type: image/png');
        imagepng($im);
        imagedestroy($im);
        exit;*/

        $hash = md5(sprintf('%s_%s_%s_%s_%s_%s', $width, $height, $text, $textSize, $colorText, $colorBg));
        $filepath = sprintf(__DIR__ . '/../../temp/%s.png', $hash);
        imagepng($im, $filepath);
        imagedestroy($im);

        $response = $this->createResponse($filepath);
        unlink($filepath);

        return $response;
    }

    private function createResponse(string $filepath): Response
    {
        $response = new Response();
        $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, 'image.png');
        $response->headers->set('Content-Disposition', $disposition);
        $response->headers->set('Content-Type', 'image/png');
        $response->headers->set('Content-length', filesize($filepath));
        $response->sendHeaders();
        $response->setContent(file_get_contents($filepath));

        return $response;
    }

    private function hex2rgb(string $hex): ColorRgb
    {
        $hex = str_replace("#", "", $hex);

        if(strlen($hex) == 3) {
            $r = hexdec(substr($hex,0,1).substr($hex,0,1));
            $g = hexdec(substr($hex,1,1).substr($hex,1,1));
            $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        } else {
            $r = hexdec(substr($hex,0,2));
            $g = hexdec(substr($hex,2,2));
            $b = hexdec(substr($hex,4,2));
        }

        return new ColorRgb($r, $g, $b);
    }
}
