<?php

namespace Pastebin\Kernel\Session;

interface SessionInterface
{
    public function get(string $key, $default = null): mixed;

    public function getFlush(string $key, $default = null): mixed;

    public function set(string $key, $value): void;

    public function has(string $key): bool;

    public function delete(string $key): void;

    public function destroy(): void;
}
