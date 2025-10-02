<?php

namespace Pastebin\Middlewares;

use DateTime;
use Pastebin\Kernel\Middleware\AbstractMiddleware;
use Pastebin\Kernel\Utils\Hash;

class SessionMiddleware extends AbstractMiddleware
{
    public function handle(): void
    {
        //if sessions were deleted in db then logout user
        if ($this->auth->check() &&
            empty(
                    $this->database->first(
                        'sessions_tokens',
                        ['user_id' => $this->session->get($this->auth->sessionField())]
                    )
                )
            ) {
            $this->session->destroy();
            $this->sessionCookie->delete();
            $this->redirect->to('/signin');
        }

        if (!$this->auth->check() && $this->sessionCookie->has()) {
            $token = $this->sessionCookie->get()->get();
            $sessionToken = $this->database->first(
                table: 'sessions_tokens',
                conditions: ['session_token' => Hash::get($token)]
            );
            if (!empty($sessionToken)) {
                $expiresAt = new DateTime($sessionToken['expires_at'])->getTimestamp();
                if (time() < $expiresAt) {
                    $this->auth->createSession(userId: $sessionToken['user_id'], sessionTokenId: $sessionToken['session_token_id'], restoreSession: true);
                }
            }
        }
    }
}
