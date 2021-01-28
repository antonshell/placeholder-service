<?php

declare(strict_types=1);

namespace App\Model;

class Resolution
{
    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $height;

    public function getWidth(): int
    {
        return $this->width;
    }

    public function setWidth(int $width): Resolution
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function setHeight(int $height): Resolution
    {
        $this->height = $height;

        return $this;
    }
}
