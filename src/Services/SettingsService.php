<?php

namespace Pastebin\Services;

use Pastebin\Kernel\Database\DatabaseInterface;

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
}
