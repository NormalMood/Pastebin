<?php

namespace Pastebin\Kernel\Upload;

interface UploadedFileInterface
{
    public function move(): string|false;

    public function tmpName(): string;

    public function error(): int;

    public function size(): int;
}
