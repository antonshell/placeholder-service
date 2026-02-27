<?php

declare(strict_types=1);

namespace App\Request;

use App\Service\PlaceholderGenerator;
use Symfony\Component\HttpFoundation\Request;

class ImageRequest
{
    private ?int $width;
    private ?int $height;
    private ?string $text;
    private int $textSize;
    private string $colorText;
    private string $colorBg;
    private string $format;

    public static function create(Request $request): ImageRequest
    {
        $imageRequest = new self();

        $width = $request->get('width');
        $imageRequest->width = $width ? (int) $width : null;

        $height = $request->get('height');
        $imageRequest->height = $height ? (int) $height : null;

        $imageRequest->text = $request->get('text');
        $imageRequest->colorText = $request->get('color_text', PlaceholderGenerator::COLOR_WHITE);
        $imageRequest->colorBg = $request->get('color_bg', PlaceholderGenerator::COLOR_GREY);
        $imageRequest->textSize = abs((int) $request->get('text_size', PlaceholderGenerator::DEFAULT_TEXT_SIZE));
        $imageRequest->format = $request->get('format', PlaceholderGenerator::FORMAT_PNG);

        return $imageRequest;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function getTextSize(): int
    {
        return $this->textSize;
    }

    public function getColorText(): string
    {
        return $this->colorText;
    }

    public function getColorBg(): string
    {
        return $this->colorBg;
    }

    public function getFormat(): string
    {
        return $this->format;
    }
}
