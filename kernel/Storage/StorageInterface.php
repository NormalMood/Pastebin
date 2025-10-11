<?php

namespace Pastebin\Kernel\Storage;

use Pastebin\Kernel\Upload\UploadedFileInterface;

interface StorageInterface
{
    public function uploadPicture(UploadedFileInterface $picture, string $pictureName): string|false;

    public function setBucketsFromConfig(): void;
}
