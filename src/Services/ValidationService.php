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

    public function validateUI(string $field, $value, $valueConfirmation = null): string
    {
        $data = [];
        $validationRules = [];
        switch ($field) {
            case 'login_name':
                $validationRules['name'] = 'required|name|exists:users,name|max:100';
                $data['name'] = $value;
                break;
            case 'password':
                $validationRules['password'] = 'required|min:12|max:50';
                $data['password'] = $value;
                break;
            case 'new_password':
                $validationRules['new_password'] = 'required|min:12|max:50';
                $data['new_password'] = $value;
                if (isset($valueConfirmation)) {
                    $validationRules['new_password'] .= '|confirmed';
                    $data['new_password_confirmation'] = $valueConfirmation;
                }
                break;
            case 'new_password_confirmation':
                $validationRules['new_password_confirmation'] = 'required|min:12|max:50';
                $data['new_password_confirmation'] = $value;
                break;
            case 'forgot-name_email':
                $validationRules['email'] = 'required|email|exists:users,e_mail';
                $data['email'] = $value;
                break;
            case 'forgot-password_name':
                $validationRules['name'] = 'required|name|exists:users,name|max:100';
                $data['name'] = $value;
                break;
            case 'register_name':
                $validationRules['name'] = 'required|name|max:100|unique:names_taken,name';
                $data['name'] = $value;
                break;
            case 'register_email':
                $validationRules['email'] = 'required|email|unique:users,e_mail';
                $data['email'] = $value;
                break;
            case 'post_text':
                $validationRules['text'] = 'required|max_bytes:10485760';
                $data['text'] = $value;
                break;
            case 'post_title':
                $validationRules['title'] = 'max:255';
                $data['title'] = $value;
                break;
            case 'post_category_id':
                $validationRules['category_id'] = 'required';
                $data['category_id'] = $value;
                break;
            case 'post_syntax_id':
                $validationRules['syntax_id'] = 'required';
                $data['syntax_id'] = $value;
                break;
            case 'post_interval_id':
                $validationRules['interval_id'] = 'required';
                $data['interval_id'] = $value;
                break;
            case 'post_post_visibility_id':
                $validationRules['post_visibility_id'] = 'required';
                $data['post_visibility_id'] = $value;
                break;
            default:
                return 'Ошибка проверки поля';
        }
        $validation = $this->request->validator()->validate($data, $validationRules);
        if (!$validation) {
            $errors = $this->request->errors();
            $key = key($errors);
            $error = $errors[$key][0];
            return ErrorsMapper::getReadableError(field: $key, error: $error);
        } else {
            return 'OK';
        }
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
            $this->session->set(
                $field,
                ErrorsMapper::getReadableError($field, $errors[0])
            );
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
