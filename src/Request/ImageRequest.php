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
    private ?int $textSize;
    private string $colorText;
    private string $colorBg;

    public static function create(Request $request): ImageRequest
    {
        $imageRequest = new self();
        $imageRequest->width = abs((int) $request->get('width'));
        $imageRequest->height = abs((int) $request->get('height'));
        $imageRequest->text = $request->get('text');
        $imageRequest->colorText = $request->get('color_text', PlaceholderGenerator::COLOR_WHITE);
        $imageRequest->colorBg = $request->get('color_bg', PlaceholderGenerator::COLOR_GREY);
        $imageRequest->textSize = abs((int) $request->get('text_size', PlaceholderGenerator::DEFAULT_TEXT_SIZE));

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
}
