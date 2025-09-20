<?php

namespace Pastebin\Kernel\View;

use Pastebin\Kernel\Auth\AuthInterface;
use Pastebin\Kernel\Config\ConfigInterface;
use Pastebin\Kernel\Exceptions\ViewNotFoundException;
use Pastebin\Kernel\Session\SessionInterface;
use Pastebin\Kernel\Utils\Token;

class View implements ViewInterface
{
    private string $title;

    public function __construct(
        private SessionInterface $session,
        private ConfigInterface $config,
        private AuthInterface $auth
    ) {
    }

    public function page(string $name, array $data = [], string $title = ''): void
    {
        $this->title = $title;
        $pagePath = APP_PATH . "/views/pages/$name.php";
        if (!file_exists($pagePath)) {
            throw new ViewNotFoundException("View $name not found");
        }
        if (!in_array(needle: $name, haystack: ['not-found', 'forbidden'])) {
            $this->setCSRFToken();
        }
        $this->setCSP();
        extract(array_merge($this->defaultData(), $data));
        include_once $pagePath;
    }

    public function component(string $name, array $data = []): void
    {
        $componentPath = APP_PATH . "/views/components/$name.php";
        if (!file_exists($componentPath)) {
            echo "Component $name not found";
            return;
        }
        extract(array_merge($this->defaultData(), $data));
        include $componentPath;
    }

    private function defaultData(): array
    {
        return [
            'view' => $this,
            'session' => $this->session,
            'config' => $this->config,
            'auth' => $this->auth,
            'csrfToken' => $this->session->get('csrf_token')
        ];
    }

    public function title(): string
    {
        return $this->title;
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
