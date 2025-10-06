<?php

namespace Pastebin\Controllers;

use Pastebin\Kernel\Controller\Controller;
use Pastebin\Mappers\IntervalMapper;
use Pastebin\Mappers\PostVisibilityMapper;
use Pastebin\Models\Interval;
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
        $intervals = $this->intervalService()->all();
        if (!$this->auth()->check()) {
            $intervals = array_filter(
                array: $intervals,
                callback: fn (Interval $interval): bool => $interval->id() !== INFINITY_INTERVAL_ID
            );
        }
        $data = [
            'categories' => $this->categoryService()->all(),
            'syntaxes' => $this->syntaxService()->all(),
            'intervals' => IntervalMapper::getMapped($intervals),
            'postVisibilities' => PostVisibilityMapper::getMapped($this->postVisibilityService()->all())
        ];
        $this->view('post/create', $data, title: 'Создание поста');
    }

    public function store(): void
    {
        if ($this->auth()->check()) {
            $this->validationService()->validate(
                validationRules: [
                    'text' => 'required|max_bytes:10485760',
                    'title' => 'max:255',
                    'category_id' => 'required',
                    'syntax_id' => 'required',
                    'interval_id' => 'required',
                    'post_visibility_id' => 'required'
                ],
                redirectUrl: '/'
            );
            $postLink = $this->postService()->save(
                text: $this->request()->input('text'),
                categoryId: $this->request()->input('category_id'),
                syntaxId: $this->request()->input('syntax_id'),
                intervalId: $this->request()->input('interval_id'),
                postVisibilityId: $this->request()->input('post_visibility_id'),
                title: $this->request()->input('title'),
                userId: $this->session()->get($this->auth()->sessionField())
            );
        } else {
            $this->validationService()->validate(
                validationRules: [
                    'text' => 'required|max_bytes:10485760',
                    'title' => 'max:255',
                    'category_id' => 'required',
                    'syntax_id' => 'required',
                    'interval_id' => 'required',
                ],
                redirectUrl: '/'
            );
            if ($this->request()->input('interval_id') === INFINITY_INTERVAL_ID) {
                $this->redirect()->to('/');
            }
            $postLink = $this->postService()->save(
                text: $this->request()->input('text'),
                categoryId: $this->request()->input('category_id'),
                syntaxId: $this->request()->input('syntax_id'),
                intervalId: $this->request()->input('interval_id'),
                postVisibilityId: UNLISTED_POST_VISIBILITY_ID,
                title: $this->request()->input('title'),
                userId: $this->session()->get($this->auth()->sessionField())
            );
        }
        $this->redirect()->to("/post?link=$postLink");
    }

    public function show(): void
    {
        $post = $this->postService()->getPost($this->request()->input('link'));
        $this->view('post/show', ['post' => $post], title: 'Пост');
    }

    public function edit(): void
    {
        $post = $this->postService()->getPost($this->request()->input('link'));
        $data = [
            'categories' => $this->categoryService()->all(),
            'syntaxes' => $this->syntaxService()->all(),
            'intervals' => IntervalMapper::getMapped($this->intervalService()->all()),
            'postVisibilities' => PostVisibilityMapper::getMapped($this->postVisibilityService()->all()),
            'post' => $post
        ];
        $this->view('post/edit', $data, 'Редактирование поста');
    }

    public function update(): void
    {
        $postLink = $this->request()->input('link');
        $this->validationService()->validate(
            validationRules: [
                    'text' => 'required|max_bytes:10485760',
                    'title' => 'max:255',
                    'category_id' => 'required',
                    'syntax_id' => 'required',
                    'interval_id' => 'required',
                    'post_visibility_id' => 'required'
                ],
            redirectUrl: "/post/edit?link=$postLink"
        );
        $this->postService()->updatePost(
            postLink: $postLink,
            text: $this->request()->input('text'),
            categoryId: $this->request()->input('category_id'),
            syntaxId: $this->request()->input('syntax_id'),
            intervalId: $this->request()->input('interval_id'),
            postVisibilityId: $this->request()->input('post_visibility_id'),
            title: $this->request()->input('title')
        );
        $this->redirect()->to("/post?link=$postLink");
    }

    public function destroy(): void
    {
        $this->postService()->deletePost($this->request()->input('link'));
        $userName = $this->request()->input('u');
        if (isset($userName)) {
            $this->redirect()->to("/profile?u=$userName");
        }
        $this->redirect()->to('/');
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
