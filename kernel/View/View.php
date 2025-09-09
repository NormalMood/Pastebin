<?php

namespace Pastebin\Kernel\View;

use Pastebin\Kernel\Auth\AuthInterface;
use Pastebin\Kernel\Config\ConfigInterface;
use Pastebin\Kernel\Exceptions\ViewNotFoundException;
use Pastebin\Kernel\Session\SessionInterface;
use Pastebin\Kernel\Utils\Token;

class View implements ViewInterface
{
    public function __construct(
        private SessionInterface $session,
        private ConfigInterface $config,
        private AuthInterface $auth
    ) {
    }

    public function page(string $name, array $data = []): void
    {
        $pagePath = APP_PATH . "/views/pages/$name.php";
        if (!file_exists($pagePath)) {
            throw new ViewNotFoundException("View $name not found");
        }
        $this->setCSRFToken();
        $this->setCSP();
        extract(array_merge($this->defaultData(), $data));
        include_once $pagePath;
    }

    private function defaultData(): array
    {
        return [
            'session' => $this->session,
            'config' => $this->config,
            'auth' => $this->auth,
            'csrfToken' => $this->session->get('csrf_token')
        ];
    }

    //set Content-Security-Policy
    private function setCSP(): void
    {
        header("Content-Security-Policy: default-src 'self'; script-src 'self';");
    }

    private function setCSRFToken(): void
    {
        $this->session->set('csrf_token', Token::random());
    }
}
