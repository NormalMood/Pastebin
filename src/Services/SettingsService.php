<?php

namespace Pastebin\Services;

use Pastebin\Kernel\Auth\AuthInterface;
use Pastebin\Kernel\Database\DatabaseInterface;
use Pastebin\Kernel\Session\SessionInterface;
use Pastebin\Kernel\Upload\UploadedFileInterface;
use Pastebin\Kernel\Utils\Hash;

class SettingsService
{
    public function __construct(
        private DatabaseInterface $database,
        private AuthInterface $auth,
        private SessionInterface $session
    ) {
    }

    public function getAccountData(int $userId, ?string $userName): array
    {
        $user = $this->database->first('users', ['name' => $userName]);
        if (!empty($user) && ($user['user_id'] === $userId)) {
            return [
                'userName' => $user['name'],
                'email' => $user['e_mail']
            ];
        }
        return [];
    }

    public function savePicture(string $userName, UploadedFileInterface $uploadedFile): void
    {
        if ($uploadedFile->error() === UPLOAD_ERR_NO_FILE) {
            $this->session->set('image', 'Необходимо выбрать изображение');
            return;
        }
        if ($uploadedFile->error() === UPLOAD_ERR_INI_SIZE) {
            $this->session->set('image', 'Размер изображения не должен превышать 16 МБ');
            return;
        }
        if ($uploadedFile->error() !== UPLOAD_ERR_OK) {
            $this->session->set('image', 'Произошла ошибка при загрузке изображения');
            return;
        }
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $uploadedFile->tmpName());
        finfo_close($finfo);
        $allowedMimeTypes = [
            'image/jpeg',
            'image/png'
        ];
        if (in_array($mimeType, $allowedMimeTypes)) {
            $picturePath = $uploadedFile->move();
            $this->database->update(
                table: 'users',
                data: ['picture_blob_link' => $picturePath],
                conditions: ['name' => $userName]
            );
            $this->session->set('settingsSaved', 'Настройки сохранены');
        } else {
            $this->session->set('image', 'Аватарка должна быть формата jpeg или png');
        }
    }

    public function changePassword(int $userId, string $password, string $newPassword): void
    {
        $user = $this->database->first('users', ['user_id' => $userId]);
        if (hash_equals(known_string: $user['password'], user_string: Hash::get($password))) {
            $this->database->update(
                table: 'users',
                data: ['password' => Hash::get($newPassword)],
                conditions: ['user_id' => $userId]
            );
            $this->session->set('resetPassword', 'Пароль обновлен');
        } else {
            $this->session->set('incorrectPassword', 'Неверный пароль');
        }
    }

    public function deleteAccount(int $userId, string $password): bool
    {
        $user = $this->database->first('users', ['user_id' => $userId]);
        if (hash_equals($user['password'], Hash::get($password))) {
            $this->database->delete('posts', ['user_id' => $userId]);
            $this->auth->logout();
            $this->database->delete('users', ['user_id' => $userId]);
            return true;
        } else {
            $this->session->set('incorrectPassword', 'Неверный пароль');
            return false;
        }
    }
}
