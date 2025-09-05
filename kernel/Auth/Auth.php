<?php

namespace Pastebin\Kernel\Auth;

use Pastebin\Kernel\Config\ConfigInterface;
use Pastebin\Kernel\Database\DatabaseInterface;
use Pastebin\Kernel\Session\SessionInterface;

class Auth implements AuthInterface
{
    public function __construct(
        private ConfigInterface $config,
        private DatabaseInterface $database,
        private SessionInterface $session
    ) {
    }

    public function register(string $name, string $email, string $password): string
    {
    }

    public function attempt(string $username, string $password): bool
    {
    }

    public function logout(): void
    {
    }

    public function table(): string
    {
    }

    public function username(): string
    {
    }

    public function password(): string
    {
    }

    public function sessionField(): string
    {
    }
}
