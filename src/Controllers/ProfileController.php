<?php

namespace Pastebin\Controllers;

use Pastebin\Kernel\Controller\Controller;
use Pastebin\Services\ProfileService;
use Pastebin\Services\ValidationService;

class ProfileController extends Controller
{
    private ProfileService $profileService;

    private ValidationService $validationService;

    public function show(): void
    {
        $data = $this->profileService()->getPosts(userName: $this->request()->input('u'));
        $this->view('profile', $data, title: 'Профиль');
    }

    private function profileService(): ProfileService
    {
        if (!isset($this->profileService)) {
            $this->profileService = new ProfileService(
                $this->database()
            );
        }
        return $this->profileService;
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
