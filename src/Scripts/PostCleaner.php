<?php

namespace Pastebin\Scripts;

//This script will be called indepedently from project by cron, that's why i need app path and env vars
define('PROJECT_FOLDER', dirname(dirname(__DIR__)));
require_once PROJECT_FOLDER . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(PROJECT_FOLDER);
$dotenv->load();

use Pastebin\Kernel\Database\Database;
use Pastebin\Kernel\Database\DatabaseInterface;
use Pastebin\Kernel\Storage\Storage;
use Pastebin\Kernel\Storage\StorageInterface;

class PostCleaner
{
    public function __construct(
        private DatabaseInterface $database,
        private StorageInterface $storage
    ) {
    }

    public function deleteExpiredPosts(): void
    {
        $expiredPostBlobLinks = $this->database->execSelect(
            sql: 'SELECT post_blob_link FROM posts WHERE expires_at < now()'
        );
        $this->database->execSQL(sql: 'DELETE FROM posts WHERE expires_at < now()', params: []);
        foreach ($expiredPostBlobLinks as $expiredPostBlobLink) {
            $this->storage->deletePost(postBlobLink: $expiredPostBlobLink['post_blob_link']);
        }
    }
}

$postCleaner = new PostCleaner(database: new Database(), storage: new Storage());
$postCleaner->deleteExpiredPosts();
