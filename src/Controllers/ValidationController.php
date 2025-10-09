<?php

namespace Pastebin\Controllers;

use Pastebin\Kernel\Controller\Controller;
use Pastebin\Services\ValidationService;

class ValidationController extends Controller
{
    private ValidationService $validationService;

    public function validate()
    {
        $field = $this->request()->input('field');
        $value = $this->request()->input('value');
        $valueConfirmation = $this->request()->input('value_confirmation');
        if (isset($field) && ($field !== '')) {
            $response['message'] = $this->validationService()->validateUI(
                $field,
                $value,
                $valueConfirmation
            );
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            $this->view('not-found');
        }
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
