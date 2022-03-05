<?php

declare(strict_types=1);

namespace App\Service;

use App\Helper\PathHelper;
use App\Model\ColorRgb;
use App\Model\ImageResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class PlaceholderGenerator
{
    public const COLOR_WHITE = 'fff';
    public const COLOR_GREY = '888';
    public const IMAGE_TYPE_PNG = 'png';

    public const DEFAULT_TEXT_SIZE = 28;

    public function __construct(
        private ImageGeneratorFactory $imageGeneratorFactory
    ) {}

    public function generate(
        int $width,
        int $height,
        ?string $text = null,
        int $textSize = self::DEFAULT_TEXT_SIZE,
        string $colorText = self::COLOR_WHITE,
        string $colorBg = self::COLOR_GREY,
        string $format = self::IMAGE_TYPE_PNG
    ): Response {
        if (null === $text) {
            $text = sprintf('%sx%s', $width, $height);
        }
        $imageResponse = $this->imageGeneratorFactory->create($format)
            ->generate(
                $width,
                $height,
                $text,
                $textSize,
                $colorText,
                $colorBg
            );

        return $this->createResponse($imageResponse);
    }

    private function createResponse(ImageResponse $imageResponse): Response
    {
        $response = new Response();
        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            $imageResponse->getFilename()
        );
        $response->headers->set('Content-Disposition', $disposition);
        $response->headers->set('Content-Type', $imageResponse->getContentType());
        $response->headers->set('Content-length', (string) $imageResponse->getContentLength());
        $response->sendHeaders();
        $response->setContent(file_get_contents($imageResponse->getFilePath()));

        return $response;
    }
}
