<?php

namespace Pastebin\Services;

use Pastebin\Kernel\Http\RedirectInterface;
use Pastebin\Kernel\Http\RequestInterface;
use Pastebin\Kernel\Mapper\ErrorsMapper;
use Pastebin\Kernel\Session\SessionInterface;

class ValidationService
{
    public function __construct(
        private RequestInterface $request,
        private SessionInterface $session,
        private RedirectInterface $redirect
    ) {
    }

    public function validate(array $validationRules, string $redirectUrl, bool $redirect = true): bool
    {
        $validation = $this->request->validate($validationRules);
        if (!$validation) {
            $this->setErrorFields($this->request->errors());
            $this->setErrorMessages($this->request->errors());
            if ($redirect) {
                $this->redirect->to($redirectUrl);
            }
        }
        return $validation;
    }

    private function setErrorFields(array $fieldErrors): void
    {
        foreach ($fieldErrors as $field => $errors) {
            $this->session->set($field, true);
        }
    }

    private function setErrorMessages(array $fieldErrors): void
    {
        $errorMessages = [];
        foreach ($fieldErrors as $field => $errors) {
            $errorMessages[] = ErrorsMapper::getReadableError($field, $errors[0]);
        }
        if (!empty($errorMessages)) {
            $this->session->set('errorMessages', $errorMessages);
        }
    }
}
