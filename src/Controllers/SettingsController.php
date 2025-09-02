<?php

namespace App\Controllers;

use App\Kernel\Controller\Controller;

class SettingsController extends Controller
{
    public function index(): void
    {
        $this->view('settings');
    }
}
