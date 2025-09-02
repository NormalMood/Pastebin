<?php

namespace Pastebin\Controllers;

use Pastebin\Kernel\Controller\Controller;

class PostController extends Controller
{
    public function index()
    {
        $this->view('post');
    }
}
