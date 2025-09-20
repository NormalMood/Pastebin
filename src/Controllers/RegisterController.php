<?php

namespace Pastebin\Controllers;

use Pastebin\Kernel\Controller\Controller;
use Pastebin\Services\RegisterService;
use Pastebin\Services\ValidationService;

class RegisterController extends Controller
{
    private RegisterService $registerService;

    private ValidationService $validationService;

    public function showRegistrationForm(): void
    {
        if ($this->auth()->check()) {
            $this->view(name: 'forbidden', title: 'Доступ запрещен');
        } else {
            $this->view(name: 'auth/register', title: 'Регистрация');
        }
    }

    public function register(): void
    {
        $this->validationService()->validate(
            validationRules: [
                'name' => 'required|name|max:100|unique:names_taken,name',
                'email' => 'required|email|unique:users,e_mail',
                'password' => 'required|min:12|max:50'
            ],
            redirectUrl: '/signup'
        );
        $this->registerService()->register(
            $this->request()->input('name'),
            $this->request()->input('email'),
            $this->request()->input('password')
        );
    }

    public function showResendLinkForm(): void
    {
        if ($this->session()->has($this->config()->get('auth.verification_link_field'))) {
            $this->view(name: 'auth/resend-link', title: 'Ссылка активации');
        } else {
            $this->view(name: 'forbidden', title: 'Доступ запрещен');
        }
    }

    public function resendLink(): void
    {
        $this->validationService()->validate(
            validationRules: [
                'email' => 'required|exists:users,e_mail|email'
            ],
            redirectUrl: '/resend-link'
        );
        $this->registerService()->resendLink($this->request()->input('email'));
    }

    public function verify(): void
    {
        $this->registerService()->verify($this->request()->input('token'));
    }

    private function registerService(): RegisterService
    {
        if (!isset($this->registerService)) {
            $this->registerService = new RegisterService(
                $this->database(),
                $this->redirect(),
                $this->mailSender(),
                $this->session(),
                $this->config(),
                $this->auth()
            );
        }
        return $this->registerService;
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
