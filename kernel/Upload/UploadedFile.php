<?php

namespace Pastebin\Kernel\Upload;

use Pastebin\Kernel\Utils\Token;

class UploadedFile implements UploadedFileInterface
{
    public function __construct(
        public readonly string $name,
        public readonly string $type,
        public readonly string $tmpName,
        public readonly int $error,
        public readonly int $size
    ) {
    }

    public function tmpName(): string
    {
        return $this->tmpName;
    }

    public function size(): int
    {
        return $this->size;
    }

    public function move(): string|false
    {
        $storagePath = APP_PATH . '/storage/picture';
        if (!is_dir($storagePath)) {
            mkdir(directory: $storagePath, permissions: 0777, recursive: true);
        }
        $fileName = Token::random() . ".{$this->getExtension()}";
        $filePath = "$storagePath/$fileName";
        if (move_uploaded_file($this->tmpName, $filePath)) {
            return $filePath;
        }
        return false;
    }

    private function getExtension(): string
    {
        return pathinfo($this->name, PATHINFO_EXTENSION);
    }
}
