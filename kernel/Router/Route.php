<?php

namespace Pastebin\Kernel\Router;

class Route
{
    public function __construct(
        private string $uri,
        private string $method,
        private $action,
        private array $middlewares = []
    ) {
    }

    public static function get(string $uri, $action, array $middlewares = []): static
    {
        return new static(uri: $uri, method: GET, action: $action, middlewares: $middlewares);
    }

    public static function post(string $uri, $action, array $middlewares = []): static
    {
        return new static(uri: $uri, method: POST, action: $action, middlewares: $middlewares);
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getAction(): mixed
    {
        return $this->action;
    }

    public function hasMiddlewares(): bool
    {
        return !empty($this->middlewares);
    }

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}
