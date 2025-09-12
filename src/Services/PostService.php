<?php

namespace Pastebin\Services;

use DateTime;
use Pastebin\Kernel\Database\DatabaseInterface;
use Pastebin\Kernel\Utils\PostLink;
use Pastebin\Kernel\Utils\Token;
use Pastebin\Models\Category;
use Pastebin\Models\Post;
use Pastebin\Models\Syntax;

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
        $postLink = PostLink::get();
        $postBlobLink = APP_PATH . '/storage/' . Token::random() . '.txt';
        file_put_contents($postBlobLink, $text);
        $this->database->execSQL(
            sql: "INSERT INTO posts (title, category_id, syntax_id, post_visibility_id, created_at, expires_at, post_link, post_blob_link, user_id) " .
            "VALUES ('$title', $categoryId, $syntaxId, $postVisibilityId, now(), now() + interval '{$interval['name']}', '$postLink', '$postBlobLink', $userId)"
        );
    }

    public function getPost(string $postLink): Post|null
    {
        $post = $this->database->first('posts', ['post_link' => $postLink]);
        $expiresAt = new DateTime($post['expires_at'])->getTimestamp();
        if (time() > $expiresAt) {
            $this->removePost($postLink);
            return null;
        }
        $category = $this->database->first('categories', ['category_id' => $post['category_id']]);
        $syntax = $this->database->first('syntaxes', ['syntax_id' => $post['syntax_id']]);
        $user = $this->database->first('users', ['user_id' => $post['user_id']]);
        return new Post(
            postLink: $post['post_link'],
            text: file_get_contents($post['post_blob_link']),
            title: $post['title'],
            category: new Category(
                id: $category['category_id'],
                name: $category['name']
            ),
            syntax: new Syntax(
                id: $syntax['syntax_id'],
                name: $syntax['name'],
                codemirror5Mode: $syntax['codemirror5_mode']
            ),
            createdAt: $post['created_at'],
            expiresAt: $post['expires_at'],
            author: $user['name']
        );
    }

    public function removePost(string $postLink): void
    {
        $post = $this->database->first('posts', ['post_link' => $postLink]);
        $this->database->delete('posts', ['post_id' => $post['post_id']]);
        unlink($post['post_blob_link']);
    }
}
