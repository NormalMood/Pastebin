<?php

namespace Pastebin\Services;

use DateTime;
use Pastebin\Kernel\Database\DatabaseInterface;
use Pastebin\Models\Author;
use Pastebin\Models\Interval;
use Pastebin\Models\Post;
use Pastebin\Models\PostVisibility;
use Pastebin\Models\Syntax;

class ProfileService
{
    private PostService $postService;

    public function __construct(
        private DatabaseInterface $database
    ) {
    }

    public function getPosts(?string $userName): array
    {
        if (empty($userName)) {
            return [];
        }
        $user = $this->database->first('users', ['name' => $userName]);
        if (empty($user)) {
            return [];
        }
        $posts = $this->database->get('posts', ['user_id' => $user['user_id']]);
        $author = new Author(id: $user['user_id'], name: $userName, createdAt: $user['created_at']);
        if (empty($posts)) {
            return [
                'author' => $author,
                'posts' => null
            ];
        }
        $profilePosts = [];
        foreach ($posts as $post) {
            if (($post['expires_at'] !== POSTGRES_INFINITY_DATE) &&
                (time() > new DateTime($post['expires_at'])->getTimestamp())) {
                $this->postService()->deletePost($post['post_link']);
            } else {
                $interval = $this->database->first('intervals', ['interval_id' => $post['interval_id']]);
                $postVisibility = $this->database->first('post_visibilities', ['post_visibility_id' => $post['post_visibility_id']]);
                $syntax = $this->database->first('syntaxes', ['syntax_id' => $post['syntax_id']]);
                $profilePosts[] = new Post(
                    postLink: $post['post_link'],
                    text: '',
                    title: $post['title'],
                    category: null,
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
                    author: '',
                    authorId: null
                );
            }
        }
        return [
            'author' => $author,
            'posts' => $profilePosts
        ];
    }

    private function postService(): PostService
    {
        if (!isset($this->postService)) {
            $this->postService = new PostService($this->database);
        }
        return $this->postService;
    }
}
