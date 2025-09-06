<?php

namespace Pastebin\Controllers;

use Pastebin\Kernel\Controller\Controller;

class ProfileController extends Controller
{
    public function index(): void
    {
        $this->view('profile');
    }
}
