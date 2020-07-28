<?php

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

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @param int $width
     * @return Resolution
     */
    public function setWidth(int $width): Resolution
    {
        $this->width = $width;
        return $this;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @param int $height
     * @return Resolution
     */
    public function setHeight(int $height): Resolution
    {
        $this->height = $height;
        return $this;
    }
}