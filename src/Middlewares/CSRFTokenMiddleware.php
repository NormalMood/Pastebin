<?php

namespace Pastebin\Middlewares;

use Pastebin\Kernel\Exceptions\InvalidCSRFTokenException;
use Pastebin\Kernel\Middleware\AbstractMiddleware;

class CSRFTokenMiddleware extends AbstractMiddleware
{
    public function handle(): void
    {
        $csrfTokenSupplied = $this->request->input('csrf_token');
        if (empty($csrfTokenSupplied) || !hash_equals(known_string: $this->session->get('csrf_token'), user_string: $csrfTokenSupplied)) {
            throw new InvalidCSRFTokenException("Invalid CSRF-Token supplied: $csrfTokenSupplied");
        }
    }
}
