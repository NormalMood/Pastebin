<?php

namespace Pastebin\Kernel\MailSender;

use Pastebin\Kernel\Config\ConfigInterface;
use PHPMailer\PHPMailer\PHPMailer;

class MailSender implements MailSenderInterface
{
    private PHPMailer $mailer;

    public function __construct(
        private ConfigInterface $config
    ) {
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
            return false;
        }
    }

    private function initMailer(): void
    {
        $this->mailer = new PHPMailer(exceptions: true);
        $this->mailer->isSMTP();
        $this->mailer->Host = $this->config->get('mailer.SMTP_HOST');
        $this->mailer->Port = $this->config->get('mailer.SMTP_PORT');
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $this->config->get('mailer.SMTP_USER');
        $this->mailer->Password = $this->config->get('mailer.SMTP_PASS');
        $this->mailer->setFrom(address: $this->config->get('mailer.SMTP_USER'), name: 'Pastebin');
        $this->mailer->addReplyTo($this->config->get('mailer.SMTP_USER'), 'Reply-to');
        $this->mailer->CharSet = PHPMailer::CHARSET_UTF8;
    }
}
