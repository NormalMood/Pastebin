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
        $data = $this->settingsService()->getAccountData(
            userId: $this->session()->get($this->auth()->sessionField()),
            userName: $this->request()->input('u')
        );
        if (!isset($data['userName'])) {
            $this->view(name: 'forbidden', title: 'Доступ запрещен');
        } else {
            $this->view('settings', $data, title: 'Настройки');
        }
    }

    public function savePicture(): void
    {
        $this->settingsService()->savePicture(
            userName: $this->request()->input('u'),
            uploadedFile: $this->request()->file('picture')
        );
        $this->redirect()->to("/settings?u={$this->request()->input('u')}");
    }

    public function changePassword(): void
    {
        $this->validationService()->validate(
            validationRules: [
                'old_password' => 'required|min:12|max:50',
                'new_password' => 'required|min:12|max:50|confirmed',
                'new_password_confirmation' => 'required|min:12|max:50'
            ],
            redirectUrl: "/settings?u={$this->request()->input('u')}"
        );
        $this->settingsService()->changePassword(
            userId: $this->session()->get($this->auth()->sessionField()),
            password: $this->request()->input('old_password'),
            newPassword: $this->request()->input('new_password')
        );
        $this->redirect()->to("/settings?u={$this->request()->input('u')}");
    }

    public function deleteAccount(): void
    {
        $this->validationService()->validate(
            validationRules: [
                'password' => 'required|min:12|max:50'
            ],
            redirectUrl: "/settings?u={$this->request()->input('u')}"
        );
        $accountDeleted = $this->settingsService()->deleteAccount(
            userId: $this->session()->get($this->auth()->sessionField()),
            password: $this->request()->input('password')
        );
        if ($accountDeleted) {
            $this->redirect()->to('/?account_deleted=1');
        } else {
            $this->redirect()->to("/settings?u={$this->request()->input('u')}");
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

    private function settingsService(): SettingsService
    {
        if (!isset($this->settingsService)) {
            $this->settingsService = new SettingsService(
                $this->database(),
                $this->auth(),
                $this->session()
            );
        }
        return $this->settingsService;
    }
}
