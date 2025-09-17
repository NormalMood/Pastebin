<?php

namespace Pastebin\Controllers;

use Pastebin\Kernel\Controller\Controller;
use Pastebin\Services\SettingsService;
use Pastebin\Services\ValidationService;

class SettingsController extends Controller
{
    private SettingsService $settingsService;

    private ValidationService $validationService;

    public function edit(): void
    {
        $validation = $this->validationService()->validate(
            validationRules: [
                'u' => 'required' //to-do: exists in db
            ],
            redirectUrl: "/settings?u={$this->request()->input('u')}",
            redirect: false
        );
        if ($validation) {
            $data = $this->settingsService()->getAccountData($this->request()->input('u'));
        }
        $this->view('settings', $data ?? []);
    }

    public function savePicture(): void
    {
        $this->settingsService()->savePicture(
            $this->session()->get($this->auth()->sessionField()),
            $this->request()->file('picture')
        );
        $this->redirect()->to("/settings?u={$this->request()->input('u')}");
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

    private function settingsService(): SettingsService
    {
        if (!isset($this->settingsService)) {
            $this->settingsService = new SettingsService($this->database());
        }
        return $this->settingsService;
    }
}
