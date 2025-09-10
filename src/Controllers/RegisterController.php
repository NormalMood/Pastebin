<?php

namespace Pastebin\Controllers;

use Pastebin\Kernel\Controller\Controller;
use Pastebin\Services\RegisterService;
use Pastebin\Services\ValidationService;

class RegisterController extends Controller
{
    private RegisterService $registerService;

    private ValidationService $validationService;

    public function index(): void
    {
        $this->view('register');
    }

    public function register(): void
    {
        //to-do: validation
        $this->registerService()->register(
            $this->request()->input('name'),
            $this->request()->input('email'),
            $this->request()->input('password')
        );
    }

    public function showResend(): void
    {
        $this->view('resend-link');
    }

    public function resend(): void
    {
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
