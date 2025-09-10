<?php

namespace Pastebin\Controllers;

use Pastebin\Kernel\Controller\Controller;
use Pastebin\Services\LoginService;
use Pastebin\Services\ValidationService;

class LoginController extends Controller
{
    private LoginService $loginService;

    private ValidationService $validationService;

    public function index(): void
    {
        $this->view('login');
    }

    public function login(): void
    {
        $this->loginService()->login(
            $this->request()->input('name'),
            $this->request()->input('password')
        );
    }

    public function forgotName(): void
    {
        $this->loginService()->forgotName($this->request()->input('email'));
    }

    public function forgotPassword(): void
    {
        $this->loginService()->forgotPassword($this->request()->input('name'));
    }

    public function resetPasswordShow(): void
    {
        $this->view('reset-password', ['token' => $this->request()->input('token')]);
    }

    public function resetPassword(): void
    {
        $this->loginService()->resetPassword(
            $this->request()->input('token'),
            $this->request()->input('new_password')
        );
    }

    public function logout(): void
    {
        $this->loginService()->logout();
    }

    private function loginService(): LoginService
    {
        if (!isset($this->loginService)) {
            $this->loginService = new LoginService(
                $this->database(),
                $this->redirect(),
                $this->mailSender(),
                $this->session(),
                $this->auth()
            );
        }
        return $this->loginService;
    }

    private function validationService(): ValidationService
    {
        if (!isset($this->validationService)) {
            $this->validationService = new ValidationService(
                $this->request(),
                $this->session(),
                $this->redirect()
            );
        }
        return $this->validationService;
    }
}
