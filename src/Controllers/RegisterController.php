<?php

namespace Pastebin\Controllers;

use Pastebin\Kernel\Controller\Controller;

class RegisterController extends Controller
{
    public function index(): void
    {
        $this->view('register');
    }

    public function register(): void
    {
        var_dump(
            $this->request()->input('name'),
            $this->request()->input('email'),
            $this->request()->input('password')
        );
    }
}
