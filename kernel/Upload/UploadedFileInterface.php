<?php

namespace Pastebin\Kernel\Upload;

interface UploadedFileInterface
{
    public function tmpName(): string;

    public function type(): string;

    public function error(): int;

    public function size(): int;

    public function getExtension(): string;
}
