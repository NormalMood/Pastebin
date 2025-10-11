<?php

namespace Pastebin\Models;

class Author
{
    public function __construct(
        private ?int $id,
        private ?string $name,
        private ?string $createdAt,
        private ?string $pictureLink
    ) {
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function name(): ?string
    {
        return $this->name;
    }

    public function createdAt(): ?string
    {
        return $this->createdAt;
    }

    public function pictureLink(): ?string
    {
        return $this->pictureLink;
    }
}
