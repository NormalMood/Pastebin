<?php

namespace Pastebin\Controllers;

use Pastebin\Kernel\Controller\Controller;
use Pastebin\Services\LoginService;
use Pastebin\Services\ValidationService;

class LoginController extends Controller
{
    private LoginService $loginService;

    private ValidationService $validationService;

    public function showLoginForm(): void
    {
        if ($this->auth()->check()) {
            $this->view(name: 'forbidden', title: 'Доступ запрещен');
        } else {
            $this->view(name: 'auth/login', title: 'Вход');
        }
    }

    public function login(): void
    {
        $this->validationService()->validate(
            validationRules: [
                'name' => 'required|name|exists:users,name|max:100',
                'password' => 'required|min:12|max:50'
            ],
            redirectUrl: '/signin'
        );
        $this->loginService()->login(
            $this->request()->input('name'),
            $this->request()->input('password')
        );
    }

    public function forgotName(): void
    {
        $this->validationService()->validate(
            validationRules: [
                'email' => 'required|email|exists:users,e_mail'
            ],
            redirectUrl: '/signin'
        );
        $this->loginService()->forgotName($this->request()->input('email'));
    }

    public function forgotPassword(): void
    {
        $this->validationService()->validate(
            validationRules: [
                'forgot-password_name' => 'required|name|exists:users,name|max:100'
            ],
            redirectUrl: '/signin'
        );
        $this->loginService()->forgotPassword($this->request()->input('forgot-password_name'));
    }

    public function showResetPasswordForm(): void
    {
        $this->view(
            name: 'auth/reset-password',
            data: ['token' => $this->request()->input('token')],
            title: 'Сброс пароля'
        );
    }

    public function resetPassword(): void
    {
        $this->validationService()->validate(
            validationRules: [
                'new_password' => 'required|min:12|max:50'
            ],
            redirectUrl: '/reset-password'
        );
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
