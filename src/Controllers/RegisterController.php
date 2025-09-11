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
        $this->view('auth/register');
    }

    public function register(): void
    {
        $this->validationService()->validate(
            validationRules: [
                'name' => 'required|max:100',
                'email' => 'required|email',
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
        $this->view('auth/resend-link');
    }

    public function resendLink(): void
    {
        $this->validationService()->validate(
            validationRules: [
                'email' => 'required|email'
            ],
            redirectUrl: '/resend-link'
        );
        $this->registerService()->resendLink($this->request()->input('email'));
    }

    public function verify(): void
    {
        $this->validationService()->validate(
            validationRules: [
                'token' => 'required'
            ],
            redirectUrl: '/verify'
        );
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
