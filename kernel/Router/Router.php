<?php

namespace Pastebin\Kernel\Router;

use Pastebin\Kernel\Auth\AuthInterface;
use Pastebin\Kernel\Database\DatabaseInterface;
use Pastebin\Kernel\Http\RedirectInterface;
use Pastebin\Kernel\Http\RequestInterface;
use Pastebin\Kernel\MailSender\MailSenderInterface;
use Pastebin\Kernel\Session\SessionCookieInterface;
use Pastebin\Kernel\Session\SessionInterface;
use Pastebin\Kernel\Storage\StorageInterface;
use Pastebin\Kernel\Validator\ValidatorInterface;
use Pastebin\Kernel\View\ViewInterface;

class Router implements RouterInterface
{
    private array $routes = [
        GET => [],
        POST => []
    ];

    public function __construct(
        private ViewInterface $view,
        private RequestInterface $request,
        private DatabaseInterface $database,
        private RedirectInterface $redirect,
        private MailSenderInterface $mailSender,
        private SessionInterface $session,
        private SessionCookieInterface $sessionCookie,
        private AuthInterface $auth,
        private ValidatorInterface $validator,
        private StorageInterface $storage
    ) {
        $this->initRoutes();
    }

    public function dispatch(string $uri, string $method): void
    {
        $route = $this->findRoute($uri, $method);
        if (!$route) {
            $this->notFound();
        }
        if ($route->hasMiddlewares()) {
            foreach ($route->getMiddlewares() as $middleware) {
                /** @var \Pastebin\Kernel\Middleware\AbstractMiddleware $middleware */
                $middleware = new $middleware(
                    $this->database,
                    $this->redirect,
                    $this->auth,
                    $this->session,
                    $this->sessionCookie,
                    $this->request,
                    $this->validator
                );
                $middleware->handle();
            }
        }
        if (is_array($route->getAction())) {
            [$controller, $action] = $route->getAction();
            /**
             * @var \Pastebin\Kernel\Controller\Controller $controller
             */
            $controller = new $controller();
            call_user_func([$controller, 'setView'], $this->view);
            call_user_func([$controller, 'setRequest'], $this->request);
            call_user_func([$controller, 'setDatabase'], $this->database);
            call_user_func([$controller, 'setStorage'], $this->storage);
            call_user_func([$controller, 'setRedirect'], $this->redirect);
            call_user_func([$controller, 'setMailSender'], $this->mailSender);
            call_user_func([$controller, 'setSession'], $this->session);
            call_user_func([$controller, 'setAuth'], $this->auth);
            call_user_func(callback: [$controller, $action]);
        } else {
            call_user_func(callback: $route->getAction());
        }
    }

    private function findRoute(string $uri, string $method): Route|false
    {
        if (!isset($this->routes[$method][$uri])) {
            return false;
        }
        return $this->routes[$method][$uri];
    }

    private function notFound(): void
    {
        $this->view->page('not-found');
        exit;
    }

    private function initRoutes(): void
    {
        $routes = $this->getRoutes();
        foreach ($routes as $route) {
            $this->routes[$route->getMethod()][$route->getUri()] = $route;
        }
    }

    /**
     * @return Route[]
     */
    private function getRoutes(): array
    {
        return require_once APP_PATH . '/routes/routes.php';
    }
}
