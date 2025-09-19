<?php

namespace Pastebin\Services;

use Pastebin\Kernel\Auth\AuthInterface;
use Pastebin\Kernel\Config\ConfigInterface;
use Pastebin\Kernel\Database\DatabaseInterface;
use Pastebin\Kernel\Http\RedirectInterface;
use Pastebin\Kernel\MailSender\MailSenderInterface;
use Pastebin\Kernel\Session\SessionInterface;

class RegisterService
{
    public function __construct(
        private DatabaseInterface $database,
        private RedirectInterface $redirect,
        private MailSenderInterface $mailSender,
        private SessionInterface $session,
        private ConfigInterface $config,
        private AuthInterface $auth
    ) {
    }

    public function register(string $name, string $email, string $password): void
    {
        $verificationToken = $this->auth->register($name, $email, $password)->get();
        $this->sendVerificationLink($email, $name, $verificationToken);
        $this->session->set($this->config->get('auth.verification_link_field'), $email);
        $this->redirect->to('/resend-link');
    }

    public function resendLink(string $email): void
    {
        $user = $this->database->first('users', ['e_mail' => $email]);
        $this->sendVerificationLink($user['e_mail'], $user['name'], $user['verification_token']);
        $this->redirect->to('/resend-link');
    }

    public function verify(?string $token): void
    {
        if (empty($token)) {
            echo '<b>Ссылка недействительна</b>' ;
            exit;
        }
        $user = $this->database->first('users', ['verification_token' => $token]);
        if (empty($user)) {
            echo '<b>Ссылка недействительна</b>';
            exit;
        } else {
            //delete email for account verification from session
            $this->session->delete($this->config->get('auth.verification_link_field'));
            //delete verification token from db
            $this->database->update('users', ['verification_token' => null], ['user_id' => $user['user_id']]);

            $this->auth->createSession($user['user_id']);

            $this->session->set('userVerified', 'Аккаунт активирован');

            $this->redirect->to("/settings?u={$user['name']}");
        }
    }

    private function sendVerificationLink(string $email, string $name, string $token): void
    {
        $this->mailSender->sendHtml(
            address: $email,
            html: "<b>Здравствуйте, $name!</b><br>Для подтверждения аккаунта перейдите по ссылке: <a href=\"http://localhost/verify?token=$token\">http://localhost/verify?token=$token</a>",
            altBody: "Здравствуйте, $name! Для подтверждения аккаунта перейдите по ссылке: http://localhost/verify?token=$token",
            subject: 'Подтверждение аккаунта на Pastebin'
        );
    }
}
