<?php

namespace Pastebin\Kernel\View;

interface ViewInterface
{
    public function page(string $name, array $data = [], string $title = ''): void;

    public function title(): string;
}
