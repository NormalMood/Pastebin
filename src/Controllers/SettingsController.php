<?php

namespace Pastebin\Controllers;

use Pastebin\Kernel\Controller\Controller;

class SettingsController extends Controller
{
    public function index(): void
    {
        $this->view('settings');
    }
}
