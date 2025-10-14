<?php

define('APP_PATH', dirname(__DIR__));
require_once APP_PATH . '/kernel/constants/constants.php';

require_once APP_PATH . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(APP_PATH);
$dotenv->load();

use Pastebin\Kernel\App;

$app = new App();
$app->run();
