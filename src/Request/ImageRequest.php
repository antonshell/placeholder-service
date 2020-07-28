<?php

namespace App\Request;

use App\Service\PlaceholderGenerator;
use Symfony\Component\HttpFoundation\Request;

class ImageRequest
{
    /**
     * @var int|null
     */
    private $width;

    /**
     * @var int|null
     */
    private $height;

    /**
     * @var string|null
     */
    private $text;

    /**
     * @var int
     */
    private $textSize;

    /**
     * @var string
     */
    private $colorText;

    /**
     * @var string
     */
    private $colorBg;

    public static function create(Request $request): ImageRequest
    {
        $imageRequest = new ImageRequest();
        $imageRequest->width = $request->get('width');
        $imageRequest->height = $request->get('height');
        $imageRequest->text = $request->get('text');
        $imageRequest->colorText = $request->get('color_text', PlaceholderGenerator::COLOR_WHITE);
        $imageRequest->colorBg = $request->get('color_bg', PlaceholderGenerator::COLOR_GREY);
        $imageRequest->textSize = $request->get('text_size', PlaceholderGenerator::DEFAULT_TEXT_SIZE);

        return $imageRequest;
    }

    /**
     * @return int|null
     */
    public function getWidth(): ?int
    {
        return $this->width;
    }

    /**
     * @return int|null
     */
    public function getHeight(): ?int
    {
        return $this->height;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @return int
     */
    public function getTextSize(): int
    {
        return $this->textSize;
    }

    /**
     * @return string
     */
    public function getColorText(): string
    {
        return $this->colorText;
    }

    /**
     * @return string
     */
    public function getColorBg(): string
    {
        return $this->colorBg;
    }
}