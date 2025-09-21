<?php

namespace Pastebin\Kernel\Auth;

use Pastebin\Kernel\Utils\Token;

interface AuthInterface
{
    public function register(string $name, string $email, string $password): Token;

    public function attempt(string $username, string $password): bool;

    public function logout(): void;

    public function createSession(int $userId, bool $restoreSession = false): void;

    public function check(): bool;

    public function user(): ?User;

    public function table(): string;

    public function username(): string;

    public function password(): string;

    public function sessionField(): string;
}
