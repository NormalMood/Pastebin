<?php

namespace Pastebin\Kernel\Http;

use Pastebin\Kernel\Upload\UploadedFile;
use Pastebin\Kernel\Upload\UploadedFileInterface;
use Pastebin\Kernel\Validator\ValidatorInterface;

class Request implements RequestInterface
{
    private ValidatorInterface $validator;

    public function __construct(
        public readonly array $get,
        public readonly array $post,
        public readonly array $server,
        public readonly array $cookie,
        public readonly array $files
    ) {
    }

    public static function createFromGlobals(): static
    {
        return new static(
            $_GET,
            $_POST,
            $_SERVER,
            $_COOKIE,
            $_FILES
        );
    }

    public function uri(): string
    {
        return strtok(string: $this->server['REQUEST_URI'], token: '?');
    }

    public function method(): string
    {
        return $this->server['REQUEST_METHOD'];
    }

    public function input(string $key, $default = null): mixed
    {
        return $this->post[$key] ?? $this->get[$key] ?? $default;
    }

    public function cookie(): array
    {
        return $this->cookie;
    }

    public function file(string $key): ?UploadedFileInterface
    {
        if (!isset($this->files[$key])) {
            return null;
        }
        return new UploadedFile(
            $this->files[$key]['name'],
            $this->files[$key]['type'],
            $this->files[$key]['tmp_name'],
            $this->files[$key]['error'],
            $this->files[$key]['size']
        );
    }

    public function validate(array $validationRules): bool
    {
        $data = [];
        foreach ($validationRules as $field => $rules) {
            $data[$field] = $this->input($field);
        }
        return $this->validator->validate($data, $validationRules);
    }

    public function validator(): ValidatorInterface
    {
        return $this->validator;
    }

    public function setValidator(ValidatorInterface $validator): void
    {
        $this->validator = $validator;
    }

    public function errors(): array
    {
        return $this->validator->errors();
    }
}
