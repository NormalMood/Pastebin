<?php

namespace Pastebin\Models;

class Syntax
{
    public function __construct(
        private int $id,
        private string $name,
        private string $codemirror5Mode
    ) {
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function codemirror5Mode(): string
    {
        return $this->codemirror5Mode;
    }
}
