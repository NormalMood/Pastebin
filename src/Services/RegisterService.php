<?php

namespace Pastebin\Services;

use DateTime;
use DateTimeZone;
use Pastebin\Kernel\Config\ConfigInterface;
use Pastebin\Kernel\Database\DatabaseInterface;
use Pastebin\Kernel\Http\RedirectInterface;
use Pastebin\Kernel\MailSender\MailSenderInterface;
use Pastebin\Kernel\Session\SessionInterface;
use Pastebin\Kernel\Utils\Token;

class RegisterService
{
    public function __construct(
        private DatabaseInterface $database,
        private RedirectInterface $redirect,
        private MailSenderInterface $mailSender,
        private SessionInterface $session,
        private ConfigInterface $config
    ) {
    }

    public function register(string $name, string $email, string $password)
    {
        if (!empty($this->database->get('names_taken', ['name' => $name]))) {
            //to-do: set error session
            $this->redirect->to('/signup');
        }
        if (!empty($this->database->get('users', ['e_mail' => $email]))) {
            //to-do: set error session
            $this->redirect->to('/signup');
        }
        {
            $verificationToken = Token::random();
        }
        while (!empty(
            $this->database->get('users', ['verification_token' => $verificationToken])
        ));
        $this->database->insert('users', [
            'name' => $name,
            'e_mail' => $email,
            'password' => $password,
            'created_at' => (new DateTime('now', new DateTimeZone('UTC')))->format('Y-m-d H:i:sP'),
            'verification_token' => $verificationToken
        ]);
        $this->database->insert('names_taken', ['name' => $name]);
        $this->mailSender->sendHtml(
            address: $email,
            html: "<b>Здравствуйте, $name!</b>Для подтверждения аккаунта перейдите по ссылке: <a href=\"http://localhost/verify?token=$verificationToken\">http://localhost/verify?token=$verificationToken</a>",
            altBody: "Здравствуйте, $name! Для подтверждения аккаунта перейдите по ссылке: http://localhost/verify?token=$verificationToken",
            subject: 'Подтверждение аккаунта на Pastebin'
        );
        $this->session->set($this->config->get('auth.verification_link_field'), $email);
        $this->redirect->to('/resend-link');
    }
}
