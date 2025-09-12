<?php

namespace Pastebin\Models;

class Post
{
    public function __construct(
        private string $postLink,
        private string $text,
        private string $title,
        private Category $category,
        private Syntax $syntax,
        private string $createdAt,
        private string $expiresAt,
        private string $author
    ) {
    }

    public function postLink(): string
    {
        return $this->postLink;
    }

    public function text(): string
    {
        return $this->text;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function category(): Category
    {
        return $this->category;
    }

    public function syntax(): Syntax
    {
        return $this->syntax;
    }

    public function createdAt(): string
    {
        return $this->createdAt;
    }

    public function expiresAt(): string
    {
        return $this->expiresAt;
    }

    public function author(): string
    {
        return $this->author;
    }
}
