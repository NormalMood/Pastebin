<?php

namespace Pastebin\Kernel\Auth;

class User
{
    public function __construct(
        private int $id,
        private string $name,
        private string $email
    ) {
    }

    public function id(): int
    {
        return $this->id;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function name(): string
    {
        return $this->name;
    }
}
