<?php

namespace Pastebin\Services;

use Pastebin\Kernel\Http\RedirectInterface;
use Pastebin\Kernel\Http\RequestInterface;
use Pastebin\Kernel\Session\SessionInterface;

class ValidationService
{
    public function __construct(
        private RequestInterface $request,
        private SessionInterface $session,
        private RedirectInterface $redirect
    ) {
    }

    public function validate(array $validationRules, string $redirectUrl): void
    {
        $validation = $this->request->validate($validationRules);
        if (!$validation) {
            foreach ($this->request->errors() as $field => $errors) {
                $this->session->set($field, $errors);
            }
            $this->redirect->to($redirectUrl);
        }
    }
}
