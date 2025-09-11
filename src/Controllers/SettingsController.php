<?php

namespace Pastebin\Controllers;

use Pastebin\Kernel\Controller\Controller;

class SettingsController extends Controller
{
    public function edit(): void
    {
        $this->view('settings');
    }
}
