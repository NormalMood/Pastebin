<?php

namespace Pastebin\Kernel\Session;

class Session implements SessionInterface
{
    public function __construct()
    {
        session_start();
    }

    public function get(string $key, $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public function getFlush(string $key, $default = null): mixed
    {
        $value = $this->get($key, $default);
        $this->delete($key);
        return $value;
    }

    public function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function delete(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function destroy(): void
    {
        session_unset();
        session_destroy();
    }
}
