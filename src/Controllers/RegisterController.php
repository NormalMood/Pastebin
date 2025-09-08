<?php

namespace Pastebin\Controllers;

use Pastebin\Kernel\Controller\Controller;
use Pastebin\Services\RegisterService;

class RegisterController extends Controller
{
    private RegisterService $service;

    public function index(): void
    {
        $this->view('register');
    }

    public function register(): void
    {
        //to-do: validation
        $this->service()->register(
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
        $this->service()->resendLink($this->request()->input('email'));
    }

    public function verify(): void
    {
        $this->service()->verify($this->request()->input('token'));
    }

    private function service(): RegisterService
    {
        if (!isset($this->service)) {
            $this->service = new RegisterService(
                $this->database(),
                $this->redirect(),
                $this->mailSender(),
                $this->session(),
                $this->config(),
                $this->auth()
            );
        }
        return $this->service;
    }
}
