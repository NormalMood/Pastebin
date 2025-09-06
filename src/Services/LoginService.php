<?php

namespace Pastebin\Services;

use DateTime;
use DateTimeZone;
use Pastebin\Kernel\Config\ConfigInterface;
use Pastebin\Kernel\Database\DatabaseInterface;
use Pastebin\Kernel\Http\RedirectInterface;
use Pastebin\Kernel\MailSender\MailSenderInterface;
use Pastebin\Kernel\Session\SessionCookieInterface;
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
        private ConfigInterface $config,
        private SessionCookieInterface $sessionCookie
    ) {
    }

    public function login(string $name, string $password): void
    {
        $user = $this->database->first('users', ['name' => $name]);
        if (empty($user)) {
            //to-do: set error session
            $this->redirect->to('/signin');
        }
        if (isset($user['verification_token'])) {
            //to-do: set error session
            $this->redirect->to('/signin');
        }
        if (Hash::get($password) != $user['password']) {
            //to-do: set error session
            $this->redirect->to('/signin');
        }
        //create session:
        $this->session->set($this->config->get('auth.session_field'), $user['user_id']);


        $sessionToken = Token::random();

        $nowTimestamp = time();

        $cookieExpiresAt = $nowTimestamp + SESSION_COOKIE_TTL;

        $sessionTokenCreatedAt = new DateTime();
        $sessionTokenCreatedAt->setTimestamp($nowTimestamp);
        $sessionTokenCreatedAt->setTimezone(new DateTimeZone('UTC'));


        $sessionTokenExpiresAt = new DateTime();
        $sessionTokenExpiresAt->setTimestamp($cookieExpiresAt);
        $sessionTokenExpiresAt->setTimezone(new DateTimeZone('UTC'));
        //set session cookie:
        $this->sessionCookie->set($sessionToken, $cookieExpiresAt);

        //save session token in db
        $this->database->insert('sessions_tokens', [
                'session_token' => Hash::get($sessionToken),
                'user_id' => $user['user_id'],
                'created_at' => $sessionTokenCreatedAt->format('Y-m-d H:i:sP'),
                'expires_at' => $sessionTokenExpiresAt->format('Y-m-d H:i:sP')
            ]);
        $this->redirect->to('/profile');
    }

    public function logout(): void
    {
        $userId = $this->session->get($this->config->get('auth.session_field'));
        $this->session->destroy();
        $this->sessionCookie->remove();
        $this->database->delete('sessions_tokens', ['user_id' => $userId]);
        $this->redirect->to('/signin');
    }
}
