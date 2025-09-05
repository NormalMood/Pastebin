<?php

namespace Pastebin\Kernel\Utils;

class Token
{
    public static function get(): string
    {
        return bin2hex(string: random_bytes(length: 32));
    }
}
