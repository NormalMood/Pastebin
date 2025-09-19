<?php

namespace Pastebin\Middlewares;

use Pastebin\Kernel\Middleware\AbstractMiddleware;

class AuthorMiddleware extends AbstractMiddleware
{
    public function handle(): void
    {
        $postLink = $this->request->input('link');
        if (empty($postLink) || (strlen($postLink) !== 8)) {
            $this->redirect->to('/');
        }
        $post = $this->database->first('posts', ['post_link' => $postLink]);
        if ($this->session->get($this->auth->sessionField()) !== $post['user_id']) {
            $this->redirect->to('/');
        }
    }
}
