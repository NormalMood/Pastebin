<?php

namespace Pastebin\Controllers;

use Pastebin\Kernel\Controller\Controller;

class ProfileController extends Controller
{
    public function show(): void
    {
        $this->view('profile');
    }
}
