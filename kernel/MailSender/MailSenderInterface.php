<?php

namespace Pastebin\Kernel\MailSender;

interface MailSenderInterface
{
    public function sendText(string $address, string $text, string $subject = ''): bool;

    public function sendHtml(string $address, string $html, string $altBody, string $subject = ''): bool;
}
