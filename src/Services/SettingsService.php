<?php

namespace Pastebin\Services;

use Pastebin\Kernel\Database\DatabaseInterface;
use Pastebin\Kernel\Upload\UploadedFileInterface;

class SettingsService
{
    public function __construct(
        private DatabaseInterface $database
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
}
