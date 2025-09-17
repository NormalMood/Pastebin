<?php

namespace Pastebin\Services;

use Pastebin\Kernel\Auth\AuthInterface;
use Pastebin\Kernel\Database\DatabaseInterface;
use Pastebin\Kernel\Upload\UploadedFileInterface;
use Pastebin\Kernel\Utils\Hash;

class SettingsService
{
    public function __construct(
        private DatabaseInterface $database,
        private AuthInterface $auth
    ) {
    }

    public function getAccountData(string $userName): array
    {
        $user = $this->database->first('users', ['name' => $userName]);
        return [
            'userName' => $user['name'],
            'email' => $user['e_mail']
        ];
    }

    public function savePicture(int $userId, UploadedFileInterface $uploadedFile): void
    {
        $picturePath = $uploadedFile->move();
        $this->database->update(
            table: 'users',
            data: ['picture_blob_link' => $picturePath],
            conditions: ['user_id' => $userId]
        );
    }

    public function changePassword(int $userId, string $newPassword): void
    {
        $this->database->update(
            table: 'users',
            data: ['password' => Hash::get($newPassword)],
            conditions: ['user_id' => $userId]
        );
    }

    public function deleteAccount(int $userId): void
    {
        $this->database->delete('posts', ['user_id' => $userId]);
        $this->auth->logout();
        $this->database->delete('users', ['user_id' => $userId]);
    }
}
