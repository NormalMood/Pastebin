<?php

namespace App\Kernel\Http;

class Request implements RequestInterface
{
    public function __construct(
        public readonly array $get,
        public readonly array $post,
        public readonly array $server
    ) {
    }

    public static function createFromGlobals(): static
    {
        return new static(
            $_GET,
            $_POST,
            $_SERVER);
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
}
