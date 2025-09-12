<?php

namespace Pastebin\Middlewares;

use Pastebin\Kernel\Middleware\AbstractMiddleware;

class AuthorMiddleware extends AbstractMiddleware
{
    public function handle(): void
    {
        $validation = $this->validator->validate(
            data: ['link' => $this->request->input('link')],
            validationRules: [
                'link' => 'required|min:8|max:8' //to-do: exists in db
            ]
        );
        $post = $this->database->first('posts', ['post_link' => $this->request->input('link')]);
        if (!$validation ||
            $this->session->get($this->auth->sessionField()) !== $post['user_id']) {
            $this->redirect->to('/');
        }
    }
}
