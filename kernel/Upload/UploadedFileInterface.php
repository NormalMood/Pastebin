<?php

namespace Pastebin\Kernel\Upload;

interface UploadedFileInterface
{
    public function move(): string|false;
}
