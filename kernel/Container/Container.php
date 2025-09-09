<?php

namespace Pastebin\Kernel\Container;

use Pastebin\Kernel\Auth\Auth;
use Pastebin\Kernel\Auth\AuthInterface;
use Pastebin\Kernel\Config\Config;
use Pastebin\Kernel\Config\ConfigInterface;
use Pastebin\Kernel\Database\Database;
use Pastebin\Kernel\Database\DatabaseInterface;
use Pastebin\Kernel\Http\Redirect;
use Pastebin\Kernel\Http\RedirectInterface;
use Pastebin\Kernel\Http\Request;
use Pastebin\Kernel\Http\RequestInterface;
use Pastebin\Kernel\MailSender\MailSender;
use Pastebin\Kernel\Router\Router;
use Pastebin\Kernel\Router\RouterInterface;
use Pastebin\Kernel\Session\Session;
use Pastebin\Kernel\Session\SessionCookie;
use Pastebin\Kernel\Session\SessionCookieInterface;
use Pastebin\Kernel\Session\SessionInterface;
use Pastebin\Kernel\Utils\Hash;
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

    public readonly SessionCookieInterface $sessionCookie;

    public readonly AuthInterface $auth;

    public readonly RedirectInterface $redirect;

    public function __construct()
    {
        $this->registerServices();
    }

    private function registerServices(): void
    {
        $this->request = Request::createFromGlobals();
        $this->session = new Session();
        $this->config = new Config();
        $this->database = new Database($this->config);
        $this->redirect = new Redirect();
        $this->mailSender = new MailSender($this->config);
        $this->sessionCookie = new SessionCookie($this->config, $this->request);
        $this->auth = new Auth(
            $this->config,
            $this->database,
            $this->session,
            $this->sessionCookie
        );
        $this->view = new View($this->session, $this->config, $this->auth);
        $this->router = new Router(
            $this->view,
            $this->request,
            $this->database,
            $this->redirect,
            $this->mailSender,
            $this->session,
            $this->sessionCookie,
            $this->config,
            $this->auth
        );
        Hash::setConfig($this->config);
    }
}
