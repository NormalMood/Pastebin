<?php

namespace Pastebin\Services;

use Pastebin\Kernel\Database\DatabaseInterface;
use Pastebin\Models\Category;

class CategoryService
{
    public function __construct(
        private DatabaseInterface $database
    ) {
    }

    /**
     * Summary of all
     * @return array<Category>
     */
    public function all(): array
    {
        $categories = $this->database->get(table: 'categories');
        return array_map(
            callback: fn ($category): Category =>
                new Category(
                    id: $category['category_id'],
                    name: $category['name']
                ),
            array: $categories
        );
    }
}
