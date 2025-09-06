<?php

namespace Pastebin\Kernel\View;

use Pastebin\Kernel\Config\ConfigInterface;
use Pastebin\Kernel\Exceptions\ViewNotFoundException;
use Pastebin\Kernel\Session\SessionInterface;

class View implements ViewInterface
{
    public function __construct(
        private SessionInterface $session,
        private ConfigInterface $config
    ) {
    }

    public function page(string $name): void
    {
        $pagePath = APP_PATH . "/views/pages/$name.php";
        if (!file_exists($pagePath)) {
            throw new ViewNotFoundException("View $name not found");
        }
        extract(['session' => $this->session, 'config' => $this->config]);
        include_once $pagePath;
    }
}
