<?php

namespace Pastebin\Kernel\View;

interface ViewInterface
{
    public function page(string $name, array $data = []): void;
}
