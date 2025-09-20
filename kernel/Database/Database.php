<?php

namespace Pastebin\Kernel\Database;

use Pastebin\Kernel\Config\ConfigInterface;

class Database implements DatabaseInterface
{
    private \PDO $pdo;

    public function __construct(
        private ConfigInterface $config
    ) {
        $this->connect();
    }

    public function first(string $table, array $conditions = []): ?array
    {
        try {
            $where = '';
            if (count($conditions) > 0) {
                $where = 'WHERE ' . implode(
                    separator: ' AND ',
                    array: array_map(
                        callback: fn ($field): string => "$field = :$field",
                        array: array_keys(array: $conditions)
                    )
                );
            }
            $sql = "SELECT * FROM $table $where LIMIT 1";
            $statement = $this->pdo->prepare($sql);
            $statement->execute($conditions);
            return $statement->fetch(\PDO::FETCH_ASSOC) ?: null;
        } catch (\PDOException $e) {
            exit("Database error in first(): {$e->getMessage()}");
        }
    }

    public function get(string $table, array $conditions = [], array $order = [], int $limit = -1): array
    {
        try {
            $where = '';
            if (count($conditions) > 0) {
                $where = 'WHERE ' . implode(
                    separator: ' AND ',
                    array: array_map(
                        callback: fn ($field): string => "$field = :$field",
                        array: array_keys(array: $conditions)
                    )
                );
            }
            $sql = "SELECT * FROM $table $where";
            if (count($order) > 0) {
                $sql .= ' ORDER BY ' . implode(
                    separator: ', ',
                    array: array_map(
                        callback: fn ($field, $direction): string => "$field $direction",
                        array: array_keys(array: $order),
                        arrays: $order
                    )
                );
            }
            if ($limit > 0) {
                $sql .= " LIMIT $limit";
            }
            $statement = $this->pdo->prepare($sql);
            $statement->execute($conditions);
            return $statement->fetchAll(mode: \PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            exit("Database error in get(): {$e->getMessage()}");
        }
    }

    public function postLinkExists(string $postLink): bool
    {
        try {
            $sql = 'SELECT 1 FROM posts WHERE post_link = :post_link LIMIT 1';
            $statement = $this->pdo->prepare($sql);
            $statement->execute([':post_link' => $postLink]);
            return $statement->fetchColumn();
        } catch (\PDOException $e) {
            exit("Database error in postLinkExists(): {$e->getMessage()}");
        }
    }

    public function insert(string $table, array $data): int
    {
        try {
            $fields = array_keys($data);
            $columns = implode(', ', $fields);
            $binds = implode(separator: ', ', array: array_map(callback: fn ($field): string => ":$field", array: $fields));
            $sql = "INSERT INTO $table ($columns) VALUES ($binds)";
            $statement = $this->pdo->prepare($sql);
            $statement->execute($data);
            return (int) $this->pdo->lastInsertId();
        } catch (\PDOException $e) {
            exit("Database error in insert(): {$e->getMessage()}");
        }
    }

    public function execSQL(string $sql, array $params): int|bool
    {
        try {
            $statement = $this->pdo->prepare($sql);
            $result = $statement->execute($params);
            return $result ? $statement->rowCount() : false;
        } catch (\PDOException $e) {
            exit("Database error in execSQL(): {$e->getMessage()}");
        }
    }

    public function update(string $table, array $data, array $conditions = []): void
    {
        try {
            $fields = array_keys($data);
            $set = 'SET ' . implode(separator: ', ', array: array_map(callback: fn ($field): string => "$field = :$field", array: $fields));
            $where = '';
            if (count($conditions) > 0) {
                $where = 'WHERE '.implode(
                    separator: ' AND ',
                    array: array_map(
                        callback: fn ($field): string => "$field = :$field",
                        array: array_keys(array: $conditions)
                    )
                );
            }
            $sql = "UPDATE $table $set $where";
            $statement = $this->pdo->prepare($sql);
            $statement->execute(array_merge($data, $conditions));
        } catch (\PDOException $e) {
            exit("Database error in update(): {$e->getMessage()}");
        }
    }

    public function delete(string $table, array $conditions = []): void
    {
        try {
            $where = '';
            if (count($conditions) > 0) {
                $where = 'WHERE '.implode(
                    separator: ' AND ',
                    array: array_map(
                        callback: fn ($field): string => "$field = :$field",
                        array: array_keys(array: $conditions)
                    )
                );
            }
            $sql = "DELETE FROM $table $where";
            $statement = $this->pdo->prepare($sql);
            $statement->execute($conditions);
        } catch (\PDOException $e) {
            exit("Database error in delete(): {$e->getMessage()}");
        }
    }

    private function connect(): void
    {
        $driver = $this->config->get('database.driver');
        $host = $this->config->get('database.host');
        $port = $this->config->get('database.port');
        $database = $this->config->get('database.database');
        $username = $this->config->get('database.username');
        $password = $this->config->get('database.password');
        $charset = $this->config->get('database.charset');
        try {
            $this->pdo = new \PDO(
                "$driver:host=$host;port=$port;dbname=$database;options='--client_encoding=$charset'",
                $username,
                $password
            );
        } catch (\PDOException $exception) {
            exit("Database connection failed: {$exception->getMessage()}");
        }
    }
}
