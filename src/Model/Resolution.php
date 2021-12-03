<?php

declare(strict_types=1);

namespace App\Model;

class Resolution
{
    public function __construct(
        private int $width,
        private int $height
    ) {
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }
}
