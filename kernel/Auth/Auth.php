<?php

namespace Pastebin\Kernel\Auth;

use Pastebin\Kernel\Config\ConfigInterface;
use Pastebin\Kernel\Database\DatabaseInterface;
use Pastebin\Kernel\Session\SessionCookieInterface;
use Pastebin\Kernel\Session\SessionInterface;
use Pastebin\Kernel\Utils\Hash;
use Pastebin\Kernel\Utils\TimestampTZ;
use Pastebin\Kernel\Utils\Token;

class Auth implements AuthInterface
{
    public function __construct(
        private ConfigInterface $config,
        private DatabaseInterface $database,
        private SessionInterface $session,
        private SessionCookieInterface $sessionCookie
    ) {
    }

    public function register(string $name, string $email, string $password): Token
    {
        do {
            $verificationToken = Token::random();
        } while (!empty(
            $this->database->get($this->table(), ['verification_token' => $verificationToken])
        ));
        $this->database->insert($this->table(), [
            'name' => $name,
            'e_mail' => $email,
            'password' => Hash::get($password),
            'created_at' => TimestampTZ::convert(timestamp: time()),
            'verification_token' => $verificationToken
        ]);
        $this->database->insert('names_taken', ['name' => $name]);
        return new Token($verificationToken);
    }

    public function attempt(string $username, string $password): bool
    {
        $user = $this->database->first($this->table(), [$this->username() => $username]);
        if (isset($user['verification_token'])) {
            $this->session->set(
                'userNotVerified',
                'Аккаунт не активирован. Пожалуйста, перейдите по ссылке активации'
            );
            return false;
        }
        if (!hash_equals(known_string: $user[$this->password()], user_string: Hash::get($password))) {
            $this->session->set('incorrectPassword', 'Неверный пароль');
            return false;
        }
        $this->createSession($user['user_id']);
        return true;
    }

    public function logout(): void
    {
        $userId = $this->session->get($this->sessionField());
        $this->session->destroy();
        $this->sessionCookie->delete();
        $this->database->delete('sessions_tokens', ['user_id' => $userId]);
    }

    public function createSession(int $userId, bool $restoreSession = false): void
    {
        //create session:
        $this->session->set($this->sessionField(), $userId);

        do {
            $sessionToken = Token::random();
        } while (!empty(
            $this->database->get('sessions_tokens', ['session_token' => Hash::get($sessionToken)])
        ));

        $nowTimestamp = time();

        $cookieExpiresAt = $nowTimestamp + SESSION_COOKIE_TTL;

        //set session cookie:
        $this->sessionCookie->set($sessionToken, $cookieExpiresAt);


        if ($restoreSession) {
            //update session token in db
            $this->database->update(
                table: 'sessions_tokens',
                data: [
                    'session_token' => Hash::get($sessionToken),
                    'created_at' => TimestampTZ::convert(timestamp: $nowTimestamp),
                    'expires_at' => TimestampTZ::convert(timestamp: $cookieExpiresAt)
                ],
                conditions: [
                    'user_id' => $userId
                ]
            );
        } else {
            //save session token in db
            $this->database->insert(
                'sessions_tokens',
                [
                    'session_token' => Hash::get($sessionToken),
                    'user_id' => $userId,
                    'created_at' => TimestampTZ::convert(timestamp: $nowTimestamp),
                    'expires_at' => TimestampTZ::convert(timestamp: $cookieExpiresAt)
                ]
            );
        }
    }

    public function check(): bool
    {
        return $this->session->has($this->sessionField());
    }

    public function table(): string
    {
        return $this->config->get('auth.table', 'users');
    }

    public function username(): string
    {
        return $this->config->get('auth.username', 'name');
    }

    public function password(): string
    {
        return $this->config->get('auth.password', 'password');
    }

    public function sessionField(): string
    {
        return $this->config->get('auth.session_field', 'user_id');
    }
}
