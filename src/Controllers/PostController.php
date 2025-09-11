<?php

namespace Pastebin\Controllers;

use Pastebin\Kernel\Controller\Controller;
use Pastebin\Services\CategoryService;
use Pastebin\Services\IntervalService;
use Pastebin\Services\PostVisibilityService;
use Pastebin\Services\SyntaxService;

class PostController extends Controller
{
    private CategoryService $categoryService;

    private SyntaxService $syntaxService;

    private IntervalService $intervalService;

    private PostVisibilityService $postVisibilityService;

    public function create()
    {
        $data = [
            'categories' => $this->categoryService()->all(),
            'syntaxes' => $this->syntaxService()->all(),
            'intervals' => $this->intervalService()->all(),
            'postVisibilities' => $this->postVisibilityService()->all()
        ];
        $this->view('post/create', $data);
    }

    private function categoryService(): CategoryService
    {
        if (!isset($this->categoryService)) {
            $this->categoryService = new CategoryService($this->database());
        }
        return $this->categoryService;
    }

    private function syntaxService(): SyntaxService
    {
        if (!isset($this->syntaxService)) {
            $this->syntaxService = new SyntaxService($this->database());
        }
        return $this->syntaxService;
    }

    private function intervalService(): IntervalService
    {
        if (!isset($this->intervalService)) {
            $this->intervalService = new IntervalService($this->database());
        }
        return $this->intervalService;
    }

    private function postVisibilityService(): PostVisibilityService
    {
        if (!isset($this->postVisibilityService)) {
            $this->postVisibilityService = new PostVisibilityService($this->database());
        }
        return $this->postVisibilityService;
    }
}
