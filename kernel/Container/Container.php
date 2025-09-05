<?php

namespace Pastebin\Kernel\Container;

use Pastebin\Kernel\Auth\Auth;
use Pastebin\Kernel\Auth\AuthInterface;
use Pastebin\Kernel\Config\Config;
use Pastebin\Kernel\Config\ConfigInterface;
use Pastebin\Kernel\Database\Database;
use Pastebin\Kernel\Database\DatabaseInterface;
use Pastebin\Kernel\Http\Request;
use Pastebin\Kernel\Http\RequestInterface;
use Pastebin\Kernel\MailSender\MailSender;
use Pastebin\Kernel\Router\Router;
use Pastebin\Kernel\Router\RouterInterface;
use Pastebin\Kernel\Session\Session;
use Pastebin\Kernel\Session\SessionInterface;
use Pastebin\Kernel\View\View;
use Pastebin\Kernel\View\ViewInterface;

class Container
{
    public readonly RequestInterface $request;

    public readonly ViewInterface $view;

    public readonly RouterInterface $router;

    public readonly ConfigInterface $config;

    public readonly DatabaseInterface $database;

    public readonly MailSender $mailSender;

    public readonly SessionInterface $session;

    public readonly AuthInterface $auth;

    public function __construct()
    {
        $this->registerServices();
    }

    private function registerServices(): void
    {
        $this->request = Request::createFromGlobals();
        $this->view = new View();
        $this->router = new Router($this->view, $this->request);
        $this->config = new Config();
        $this->database = new Database($this->config);
        $this->mailSender = new MailSender($this->config);
        $this->session = new Session();
        $this->auth = new Auth($this->config, $this->database, $this->session);
    }
}
