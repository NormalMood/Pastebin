<?php

namespace Pastebin\Controllers;

use Pastebin\Kernel\Controller\Controller;
use Pastebin\Services\CategoryService;
use Pastebin\Services\IntervalService;
use Pastebin\Services\PostService;
use Pastebin\Services\PostVisibilityService;
use Pastebin\Services\SyntaxService;
use Pastebin\Services\ValidationService;

class PostController extends Controller
{
    private PostService $postService;

    private CategoryService $categoryService;

    private SyntaxService $syntaxService;

    private IntervalService $intervalService;

    private PostVisibilityService $postVisibilityService;

    private ValidationService $validationService;

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

    public function store(): void
    {
        $this->validationService()->validate(
            validationRules: [
                'text' => 'required',
                'title' => 'max:255',
                'category_id' => 'required',
                'syntax_id' => 'required',
                'interval_id' => 'required',
                'post_visibility_id' => 'required'
            ],
            redirectUrl: '/'
        );
        //to-do: if guest then INFINITY is forbidden validation
        $this->postService()->save(
            text: $this->request()->input('text'),
            categoryId: $this->request()->input('category_id'),
            syntaxId: $this->request()->input('syntax_id'),
            intervalId: $this->request()->input('interval_id'),
            postVisibilityId: $this->request()->input('post_visibility_id'),
            title: $this->request()->input('title'),
            userId: $this->session()->get($this->auth()->sessionField())
        );
    }

    public function show(): void
    {
        $validation = $this->validationService()->validate(
            validationRules: [
                'link' => 'required|min:8|max:8' //to-do: exists in db
            ],
            redirectUrl: "/post?link={$this->request()->input('link')}",
            redirect: false
        );
        if ($validation) {
            $post = $this->postService()->getPost($this->request()->input('link'));
        }
        $this->view('post/show', ['post' => $post ?? null]);
    }

    private function postService(): PostService
    {
        if (!isset($this->postService)) {
            $this->postService = new PostService($this->database());
        }
        return $this->postService;
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

    private function validationService(): ValidationService
    {
        if (!isset($this->validationService)) {
            $this->validationService = new ValidationService(
                $this->request(),
                $this->session(),
                $this->redirect()
            );
        }
        return $this->validationService;
    }
}
