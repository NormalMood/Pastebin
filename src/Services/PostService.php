<?php

namespace Pastebin\Services;

use Pastebin\Kernel\Database\DatabaseInterface;
use Pastebin\Kernel\Utils\Token;

class PostService
{
    public function __construct(
        private DatabaseInterface $database
    ) {
    }

    public function save(string $text, int $categoryId, int $syntaxId, int $intervalId, int $postVisibilityId, ?string $title = null, ?int $userId = null): void
    {
        $intervals = $this->database->get(table: 'intervals');
        $interval = current(array_filter($intervals, fn ($interval) => $interval['interval_id'] == $intervalId));
        $postLink = bin2hex(random_bytes(4));
        $postBlobLink = APP_PATH . '/storage/' . Token::random() . '.txt';
        file_put_contents($postBlobLink, $text);
        $this->database->execSQL(
            sql: "INSERT INTO posts (title, category_id, syntax_id, post_visibility_id, created_at, expires_at, post_link, post_blob_link, user_id) " .
            "VALUES ('$title', $categoryId, $syntaxId, $postVisibilityId, now(), now() + interval '{$interval['name']}', '$postLink', '$postBlobLink', $userId)"
        );
    }
}
