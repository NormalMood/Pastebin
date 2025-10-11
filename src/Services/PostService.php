<?php

namespace Pastebin\Services;

use DateTime;
use DateTimeZone;
use Pastebin\Kernel\Database\DatabaseInterface;
use Pastebin\Kernel\Http\RedirectInterface;
use Pastebin\Kernel\Session\SessionInterface;
use Pastebin\Kernel\Storage\StorageInterface;
use Pastebin\Kernel\Utils\PostLink;
use Pastebin\Kernel\Utils\Token;
use Pastebin\Models\Author;
use Pastebin\Models\Category;
use Pastebin\Models\Interval;
use Pastebin\Models\Post;
use Pastebin\Models\PostVisibility;
use Pastebin\Models\Syntax;

class PostService
{
    public function __construct(
        private DatabaseInterface $database,
        private StorageInterface $storage,
        private SessionInterface $session,
        private RedirectInterface $redirect
    ) {
    }

    public function save(
        string $text,
        int $categoryId,
        int $syntaxId,
        int $intervalId,
        int $postVisibilityId,
        string $redirectUrl,
        ?string $title = null,
        ?int $userId = null,
        ?string $postLink = null,
        ?string $postBlobLink = null,
        bool $update = false,
    ): string {
        $intervals = $this->database->get(table: 'intervals');
        $interval = current(array_filter($intervals, fn ($interval) => $interval['interval_id'] == $intervalId));
        $postLink ??= PostLink::get();
        $postBlobLink ??= $this->getUniquePostName();
        $result = $this->storage->uploadPost($text, $postBlobLink);
        if (!$result) {
            $this->session->set('postNotSaved', 'Не удалось сохранить пост');
            $this->redirect->to($redirectUrl);
        }
        if ($update) {
            $sql = "UPDATE posts SET title = :title, category_id = :category_id, syntax_id = :syntax_id, " .
                "interval_id = :interval_id, post_visibility_id = :post_visibility_id, created_at = now(), expires_at = now() + interval '{$interval['name']}' WHERE post_link = :post_link";
            $params = [
                ':title' => $title,
                ':category_id' => $categoryId,
                ':syntax_id' => $syntaxId,
                ':interval_id' => $intervalId,
                ':post_visibility_id' => $postVisibilityId,
                ':post_link' => $postLink
            ];
            $this->database->execSQL(
                $sql,
                $params
            );
        } else {
            $sql = "INSERT INTO posts (title, category_id, syntax_id, interval_id, post_visibility_id, created_at, expires_at, post_link, post_blob_link, user_id) " .
            "VALUES (:title, :category_id, :syntax_id, :interval_id, :post_visibility_id, now(), now() + interval '{$interval['name']}', :post_link, :post_blob_link, :user_id)";
            $params = [
                ':title' => $title,
                ':category_id' => $categoryId,
                ':syntax_id' => $syntaxId,
                ':interval_id' => $intervalId,
                ':post_visibility_id' => $postVisibilityId,
                ':post_link' => $postLink,
                ':post_blob_link' => $postBlobLink,
                ':user_id' => $userId
            ];
            $this->database->execSQL(
                $sql,
                $params
            );
        }
        return $postLink;
    }

    public function getPost(?string $postLink): array|null
    {
        if (!isset($postLink) || (strlen($postLink) !== 8)) {
            return [];
        }
        $post = $this->database->first('posts', ['post_link' => $postLink]);
        if (empty($post)) {
            return [];
        }
        if ($post['expires_at'] !== POSTGRES_INFINITY_DATE) {
            $expiresAt = new DateTime($post['expires_at'])->getTimestamp();
            if (time() > $expiresAt) {
                $this->deletePost($postLink);
                return [];
            }
        }
        $category = $this->database->first('categories', ['category_id' => $post['category_id']]);
        $syntax = $this->database->first('syntaxes', ['syntax_id' => $post['syntax_id']]);
        $interval = $this->database->first('intervals', ['interval_id' => $post['interval_id']]);
        $postVisibility = $this->database->first('post_visibilities', ['post_visibility_id' => $post['post_visibility_id']]);
        $user = $this->database->first('users', ['user_id' => $post['user_id']]);
        $text = $this->storage->getPost($post['post_blob_link']);
        $postObject = new Post(
            postLink: $post['post_link'],
            text: $text,
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
            interval: new Interval(
                id: $interval['interval_id'],
                name: $interval['name']
            ),
            postVisibility: new PostVisibility(
                id: $postVisibility['post_visibility_id'],
                name: $postVisibility['name']
            ),
            createdAt: $post['created_at'],
            expiresAt: $post['expires_at'],
            author: $user['name'] ?? null,
            authorId: $post['user_id'] ?? null
        );
        $authorObject = new Author($user['user_id'] ?? null, $user['name'] ?? null, $post['created_at'] ?? null, $user['picture_blob_link'] ?? null);
        return [
            'post' => $postObject,
            'author' => $authorObject
        ];
    }

    public function updatePost(
        string $postLink,
        string $text,
        int $categoryId,
        int $syntaxId,
        int $intervalId,
        int $postVisibilityId,
        string $redirectUrl,
        ?string $title = null,
        ?int $userId = null
    ): void {
        $post = $this->database->first('posts', ['post_link' => $postLink]);
        if (empty($post)) {
            $this->save(
                text: $text,
                categoryId: $categoryId,
                syntaxId: $syntaxId,
                intervalId: $intervalId,
                postVisibilityId: $postVisibilityId,
                title: $title,
                userId: $userId,
                redirectUrl: $redirectUrl,
                postLink: $postLink
            );
        } else {
            $this->save(
                text: $text,
                categoryId: $categoryId,
                syntaxId: $syntaxId,
                intervalId: $intervalId,
                postVisibilityId: $postVisibilityId,
                title: $title,
                redirectUrl: $redirectUrl,
                postLink: $postLink,
                postBlobLink: $post['post_blob_link'],
                update: true
            );
        }
    }

    public function deletePost(string $postLink): void
    {
        $post = $this->database->first('posts', ['post_link' => $postLink]);
        if ($this->storage->deletePost($post['post_blob_link'])) {
            $this->database->delete('posts', ['post_id' => $post['post_id']]);
        }
    }

    private function getUniquePostName(): string
    {
        $now = new DateTime('now', new DateTimeZone('UTC'));
        return Token::random() . "_{$now->format('d-m-Y_H-i-s')}.txt";
    }
}
