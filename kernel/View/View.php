<?php

namespace Pastebin\Kernel\View;

use Pastebin\Kernel\Auth\AuthInterface;
use Pastebin\Kernel\Config\ConfigInterface;
use Pastebin\Kernel\Exceptions\ViewNotFoundException;
use Pastebin\Kernel\Http\RequestInterface;
use Pastebin\Kernel\Session\SessionInterface;
use Pastebin\Kernel\Utils\Token;

class View implements ViewInterface
{
    private string $title;

    public function __construct(
        private SessionInterface $session,
        private ConfigInterface $config,
        private AuthInterface $auth,
        private RequestInterface $request
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
            $this->setNonce();
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
            'request' => $this->request,
            'csrfToken' => $this->session->get('csrf_token'),
            'nonce' => $this->session->get('nonce')
        ];
    }

    public function title(): string
    {
        return $this->title;
    }

    //set Content-Security-Policy
    private function setCSP(): void
    {
        header(
            "Content-Security-Policy: default-src 'self'; script-src 'self' https://cdnjs.cloudflare.com; " .
            "style-src 'self' 'nonce-{$this->session->get('nonce')}' https://cdnjs.cloudflare.com https://fonts.googleapis.com; font-src https://fonts.gstatic.com; " .
            "img-src 'self' https://pastebin-pictures-bucket.storage.yandexcloud.net;"
        );
    }

    private function setCSRFToken(): void
    {
        $this->session->set('csrf_token', Token::random());
    }

    private function setNonce(): void
    {
        $this->session->set('nonce', Token::random());
    }
}
