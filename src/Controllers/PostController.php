<?php

namespace App\Controllers;

use App\Kernel\Controller\Controller;

class PostController extends Controller
{
    public function index()
    {
        $this->view('post');
    }
}
