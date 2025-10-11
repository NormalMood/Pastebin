<?php

namespace Pastebin\Kernel\Storage;

use Pastebin\Kernel\Upload\UploadedFileInterface;

interface StorageInterface
{
    public function uploadPicture(UploadedFileInterface $picture, string $pictureName): string|false;

    public function uploadPost(string $text, string $postBlobLink): bool;

    public function setBucketsFromConfig(): void;
}
