<?php

namespace Pastebin\Kernel\Http;

interface RedirectInterface
{
    public function to(string $url): void;
}
