<?php

namespace Pastebin\Controllers;

use Pastebin\Kernel\Controller\Controller;

class LoginController extends Controller
{
    public function index(): void
    {
        $this->view('login');
    }

    public function login(): void
    {
        var_dump(
            $this->request()->input('name'),
            $this->request()->input('password')
        );
    }
}
