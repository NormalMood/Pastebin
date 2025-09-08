<?php

namespace Pastebin\Services;

use Pastebin\Kernel\Auth\AuthInterface;
use Pastebin\Kernel\Database\DatabaseInterface;
use Pastebin\Kernel\Http\RedirectInterface;
use Pastebin\Kernel\MailSender\MailSenderInterface;
use Pastebin\Kernel\Session\SessionInterface;
use Pastebin\Kernel\Utils\Hash;
use Pastebin\Kernel\Utils\Token;

class LoginService
{
    public function __construct(
        private DatabaseInterface $database,
        private RedirectInterface $redirect,
        private MailSenderInterface $mailSender,
        private SessionInterface $session,
        private AuthInterface $auth
    ) {
    }

    public function login(string $name, string $password): void
    {
        $attempt = $this->auth->attempt($name, $password);
        if (is_array($attempt)) {
            //to-do: set error session
            $this->redirect->to('/signin');
        }
        $this->redirect->to('/profile');
    }

    public function forgotName(string $email): void
    {
        $user = $this->database->first('users', ['e_mail' => $email]);
        if (empty($user)) {
            //to-do: set error session
            $this->redirect->to('/signin');
        }
        $this->mailSender->sendHtml(
            $email,
            "Здравствуйте! Вы запросили восстановление имени. Ваше имя: <b>{$user['name']}</b>",
            "Здравствуйте! Вы запросили восстановление имени. Ваше имя: {$user['name']}",
            'Восстановление имени на Pastebin'
        );
        //to-do: set success message session
        $this->redirect->to('/signin');
    }

    public function forgotPassword(string $name): void
    {
        $user = $this->database->first('users', ['name' => $name]);
        if (empty($user)) {
            //to-do: set error session
            $this->redirect->to('/signin');
        }
        $passwordResetToken = Token::random();
        $this->database->update(
            'users',
            ['password_reset_token' => $passwordResetToken],
            ['user_id' => $user['user_id']]
        );
        $this->mailSender->sendHtml(
            $user['e_mail'],
            "Здравствуйте, {$user['name']}!<br>Для сброса пароля перейдите по ссылке: <a href=\"http://localhost/reset-password?token=$passwordResetToken\">http://localhost/reset-password?token=$passwordResetToken</a>",
            "Здравствуйте, {$user['name']}! Для сброса пароля перейдите по ссылке: http://localhost/reset-password?token=$passwordResetToken",
            'Сброс пароля на Pastebin'
        );
        $this->redirect->to('/signin');
    }

    public function resetPassword(string $token, string $newPassword): void
    {
        $user = $this->database->first('users', ['password_reset_token' => $token]);
        if (empty($user)) {
            //to-do: set error session???
            echo 'Токен недействителен';
            exit;
        }
        $this->database->update(
            'users',
            ['password' => Hash::get($newPassword), 'password_reset_token' => null],
            ['user_id' => $user['user_id']]
        );
        //to-do: set success message session
        $this->redirect->to('/signin');
    }

    public function logout(): void
    {
        $this->auth->logout();
        $this->redirect->to('/signin');
    }
}
