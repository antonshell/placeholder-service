<?php

declare(strict_types=1);

namespace App\Service;

use App\Helper\PathHelper;
use App\Model\ColorRgb;
use GdImage;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PlaceholderGenerator
{
    public const COLOR_WHITE = 'fff';
    public const COLOR_GREY = '888';

    public const DEFAULT_TEXT_SIZE = 28;

    public const FORMAT_PNG = 'png';
    public const FORMAT_JPEG = 'jpeg';
    public const FORMAT_GIF = 'gif';
    public const FORMAT_SVG = 'svg';

    public function generate(
        int $width,
        int $height,
        ?string $text = null,
        int $textSize = self::DEFAULT_TEXT_SIZE,
        string $colorText = self::COLOR_WHITE,
        string $colorBg = self::COLOR_GREY,
        string $format = self::FORMAT_PNG
    ): Response {
        if (null === $text) {
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

        // create text
        $angle = 0;
        $font = PathHelper::getBasePath() . '/resources/fonts/ArialRegular.ttf';
        $points = imagettfbbox($textSize, $angle, $font, $text);
        $textWidth = abs($points[2]);
        $textHeight = abs($points[5]);

        $textStartX = $width / 2 - $textWidth / 2;
        $textStartY = $height / 2 + $textHeight / 2;
        imagettftext($im, $textSize, $angle, (int) $textStartX, (int) $textStartY, $colorText, $font, $text);

        return $this->getImageResponse($im, $format);
    }

    private function getImageResponse(GdImage $image, string $format): Response
    {
        return match ($format) {
            self::FORMAT_PNG => new StreamedResponse(fn () => imagepng($image), 200, ['Content-Type' => 'image/png']),
            self::FORMAT_JPEG => new StreamedResponse(fn () => imagejpeg($image), 200, ['Content-Type' => 'image/jpeg']),
            self::FORMAT_GIF => new StreamedResponse(fn () => imagegif($image), 200, ['Content-Type' => 'image/gif']),
            default => new JsonResponse([
                'status' => 'error',
                'message' => sprintf('Unsupported image format requested: %s', $format),
            ], Response::HTTP_BAD_REQUEST),
        };
    }

    private function hex2rgb(string $hex): ColorRgb
    {
        $hex = str_replace('#', '', $hex);

        if (3 == strlen($hex)) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }

        return new ColorRgb($r, $g, $b);
    }
}
