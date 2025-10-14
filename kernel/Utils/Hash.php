<?php

namespace Pastebin\Kernel\Utils;

class Hash
{
    public static function get(string $data): string
    {
        return hash(
            algo: 'sha256',
            data: (
                hash('sha256', (hash('sha256', $data . self::salt()) . self::salt())) . $data
            )
        );
    }

    private static function salt(): string
    {
        return $_ENV['AUTH_SALT'];
    }
}
