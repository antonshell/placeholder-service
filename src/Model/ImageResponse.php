<?php

namespace App\Model;

class ImageResponse
{
    public function __construct(
        private string $contentType,
        private int $contentLength,
        private string $filePath,
        private string $filename
    ) {}

    public function getFilename(): string {
        return $this->filename;
    }

    public function getContentType(): string {
        return $this->contentType;
    }

    public function getContentLength(): int {
        return $this->contentLength;
    }

    public function getFilePath(): string {
        return $this->filePath;
    }
}
