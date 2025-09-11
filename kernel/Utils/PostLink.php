<?php

namespace Pastebin\Kernel\Utils;

use Pastebin\Kernel\Database\DatabaseInterface;

class PostLink
{
    private static DatabaseInterface $database;

    private static string $base62 = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    private static int $base62Length = 62;

    private static int $postLinkLength = 8;

    public static function get(): string
    {
        do {
            $postLink = self::random();
        } while (self::$database->postLinkExists($postLink));
        return $postLink;
    }

    private static function random(): string
    {
        $postLink = '';
        for ($i = 0; $i < self::$postLinkLength; $i++) {
            $postLink .= self::$base62[random_int(min: 0, max: self::$base62Length - 1)];
        }
        return $postLink;
    }

    public static function setDatabase(DatabaseInterface $database): void
    {
        self::$database = $database;
    }
}
