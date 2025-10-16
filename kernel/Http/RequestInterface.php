<?php

namespace Pastebin\Kernel\Http;

use Pastebin\Kernel\Upload\UploadedFileInterface;
use Pastebin\Kernel\Validator\ValidatorInterface;

interface RequestInterface
{
    public static function createFromGlobals(): static;

    public function uri(): string;

    public function method(): string;

    public function input(string $key, $default = null): mixed;

    public function cookie(): array;

    public function file(string $key): ?UploadedFileInterface;

    public function validate(array $validationRules): bool;

    public function validator(): ValidatorInterface;

    public function setValidator(ValidatorInterface $validator): void;

    public function errors(): array;

    public function errorValues(): array;
}
