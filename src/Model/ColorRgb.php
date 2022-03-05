<?php

declare(strict_types=1);

namespace App\Model;

class ColorRgb
{
    public function __construct(
        private int $red,
        private int $green,
        private int $blue
    ) {
    }

    public static function fromHex(string $hex): self
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

        return new self($r, $g, $b);
    }

    public function getRed(): int
    {
        return $this->red;
    }

    public function getGreen(): int
    {
        return $this->green;
    }

    public function getBlue(): int
    {
        return $this->blue;
    }
}
