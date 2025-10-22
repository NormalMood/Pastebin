<?php

namespace Pastebin\Kernel\MailSender;

use PHPMailer\PHPMailer\PHPMailer;

class MailSender implements MailSenderInterface
{
    private PHPMailer $mailer;

    public function __construct()
    {
        $this->initMailer();
    }

    public function sendText(string $address, string $text, string $subject = ''): bool
    {
        try {
            $this->mailer->isHTML(false);
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($address);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $text;
            return $this->mailer->send();
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function sendHtml(string $address, string $html, string $altBody, string $subject = ''): bool
    {
        try {
            $this->mailer->isHTML(true);
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($address);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $html;
            $this->mailer->AltBody = $altBody;
            return $this->mailer->send();
        } catch (\Exception $exception) {
            echo "Mailer error: " . $this->mailer->ErrorInfo;
            return false;
        }
    }

    private function initMailer(): void
    {
        $this->mailer = new PHPMailer(exceptions: true);
        $this->mailer->isSMTP();
        $this->mailer->Host = $_ENV['SMTP_HOST'];
        $this->mailer->Port = $_ENV['SMTP_PORT'];
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $_ENV['SMTP_USER'];
        $this->mailer->Password = $_ENV['SMTP_PASS'];
        $this->mailer->setFrom(address: $_ENV['SMTP_USER'], name: 'Pastebin');
        $this->mailer->addReplyTo($_ENV['SMTP_USER'], 'Reply-to');
        $this->mailer->CharSet = PHPMailer::CHARSET_UTF8;
        $this->mailer->SMTPDebug = 3;
        $this->mailer->Debugoutput = '/var/log/mailer.log';
    }
}
