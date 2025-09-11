<?php

namespace Pastebin\Services;

use Pastebin\Kernel\Database\DatabaseInterface;
use Pastebin\Models\PostVisibility;

class PostVisibilityService
{
    public function __construct(
        private DatabaseInterface $database
    ) {
    }

    /**
     * Summary of all
     * @return array<PostVisibility>
     */
    public function all(): array
    {
        $postVisibilities = $this->database->get(table: 'post_visibilities');
        return array_map(
            callback: fn ($postVisibility): PostVisibility =>
                new PostVisibility(
                    id: $postVisibility['post_visibility_id'],
                    name: $postVisibility['name']
                ),
            array: $postVisibilities
        );
    }
}
