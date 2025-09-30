<?php

namespace Pastebin\Mappers;

use Pastebin\Models\PostVisibility;

class PostVisibilityMapper
{
    private static array $postVisibilities = [
        'PUBLIC' => 'Публичный',
        'UNLISTED' => 'По ссылке'
    ];

    public static function getValue(string $key): string
    {
        return self::$postVisibilities[$key];
    }

    /**
     * Summary of getMapped
     * @param array<PostVisibility> $postVisibilities
     * @return array<PostVisibility>
     */
    public static function getMapped(array $postVisibilities): array
    {
        $result = [];
        foreach ($postVisibilities as $postVisibility) {
            $result[] = new PostVisibility(id: $postVisibility->id(), name: self::$postVisibilities[$postVisibility->name()]);
        }
        return $result;
    }
}
