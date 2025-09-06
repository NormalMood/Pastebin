<?php

namespace Pastebin\Kernel\Utils;

use Pastebin\Kernel\Config\ConfigInterface;

class Hash
{
    private static ConfigInterface $config;

    public static function get(string $data): string
    {
        return hash(
            algo: 'sha256',
            data: (
                hash('sha256', (hash('sha256', $data . self::salt()) . self::salt())) . $data
            )
        );
    }

    public static function setConfig(ConfigInterface $config): void
    {
        self::$config = $config;
    }

    private static function salt(): string
    {
        return self::$config->get('auth.salt');
    }
}
