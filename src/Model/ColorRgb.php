<?php

declare(strict_types=1);

namespace App\Model;

class ColorRgb
{
    public function __construct(
        private int $red,
        private int $green,
        private int $blue,
    ) {
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
