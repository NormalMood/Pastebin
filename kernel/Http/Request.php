<?php

namespace App\Kernel\Http;

class Request implements RequestInterface
{
    public function __construct(
        public readonly array $server
    ) {
    }

    public static function createFromGlobals(): static
    {
        return new static($_SERVER);
    }

    public function uri(): string
    {
        return strtok(string: $this->server['REQUEST_URI'], token: '?');
    }

    public function method(): string
    {
        return $this->server['REQUEST_METHOD'];
    }
}
