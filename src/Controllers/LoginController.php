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
        $this->view(name: 'auth/login', title: 'Вход');
    }

    public function login(): void
    {
        $this->validationService()->validate(
            validationRules: [
                'name' => 'required|max:100',
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
                'email' => 'required|email'
            ],
            redirectUrl: '/signin'
        );
        $this->loginService()->forgotName($this->request()->input('email'));
    }

    public function forgotPassword(): void
    {
        $this->validationService()->validate(
            validationRules: [
                'name' => 'required|max:100'
            ],
            redirectUrl: '/signin'
        );
        $this->loginService()->forgotPassword($this->request()->input('name'));
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
                'token' => 'required',
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
