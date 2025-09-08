<?php

namespace Pastebin\Controllers;

use Pastebin\Kernel\Controller\Controller;
use Pastebin\Services\LoginService;

class LoginController extends Controller
{
    private LoginService $service;

    public function index(): void
    {
        $this->view('login');
    }

    public function login(): void
    {
        $this->service()->login(
            $this->request()->input('name'),
            $this->request()->input('password')
        );
    }

    public function forgotName(): void
    {
        $this->service()->forgotName($this->request()->input('email'));
    }

    public function forgotPassword(): void
    {
        $this->service()->forgotPassword($this->request()->input('name'));
    }

    public function resetPasswordShow(): void
    {
        $this->view('reset-password', ['token' => $this->request()->input('token')]);
    }

    public function resetPassword(): void
    {
        $this->service()->resetPassword(
            $this->request()->input('token'),
            $this->request()->input('new_password')
        );
    }

    public function logout(): void
    {
        $this->service()->logout();
    }

    private function service(): LoginService
    {
        if (!isset($this->service)) {
            $this->service = new LoginService(
                $this->database(),
                $this->redirect(),
                $this->mailSender(),
                $this->session(),
                $this->auth()
            );
        }
        return $this->service;
    }
}
