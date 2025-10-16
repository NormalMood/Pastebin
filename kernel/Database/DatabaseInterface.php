<?php

namespace Pastebin\Kernel\Database;

interface DatabaseInterface
{
    public function first(string $table, array $conditions = []): ?array;

    public function get(string $table, array $conditions = [], array $order = [], int $limit = -1): array;

    public function postLinkExists(string $postLink): bool;

    public function insert(string $table, array $data): int;

    public function execSQL(string $sql, array $params): int|bool;

    public function execSelect(string $sql): array;

    public function update(string $table, array $data, array $conditions = []): void;

    public function delete(string $table, array $conditions = []): void;
}
