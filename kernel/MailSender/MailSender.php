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
        $result = false;
        try {
            $this->mailer->isHTML(false);
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($address);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $text;
            $result = $this->mailer->send();
        } catch (\Exception $exception) {
            $msg = "<b>На сайте произошла ошибка. Содержимое письма продублировано ниже</b><br>$text";
            echo $msg;
            exit();
        }
        return $result;
    }

    public function sendHtml(string $address, string $html, string $altBody, string $subject = ''): bool
    {
        $result = false;
        try {
            $this->mailer->isHTML(true);
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($address);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $html;
            $this->mailer->AltBody = $altBody;
            $result = $this->mailer->send();
        } catch (\Exception $exception) {
            $msg = "<b>На сайте произошла ошибка. Содержимое письма продублировано ниже</b><br>$html";
            echo $msg;
            exit();
        }
        return $result;
    }

    private function initMailer(): void
    {
        $this->mailer = new PHPMailer(exceptions: true);
        $this->mailer->isSMTP();
        $this->mailer->Host = $_ENV['SMTP_HOST'];
        $this->mailer->Port = $_ENV['SMTP_PORT'];
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $_ENV['SMTP_USER'];
        $this->mailer->Password = $_ENV['SMTP_PASS'];
        $this->mailer->setFrom(address: $_ENV['SMTP_USER'], name: $_ENV['SMTP_USER']);
        $this->mailer->addReplyTo(address: $_ENV['SMTP_USER'], name: 'Reply-to');
        $this->mailer->CharSet = PHPMailer::CHARSET_UTF8;
    }
}
