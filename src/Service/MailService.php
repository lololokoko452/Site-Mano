<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;

class MailService
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }
    public function sendEmail(
        string $from,
        string $subject,
        string $htmlTemplate,
        string $to,
        string $message,
        string $name
    ): void
    {
        $email = (new TemplatedEmail())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->htmlTemplate($htmlTemplate)
            ->context([
                'from' => $from,
                'to' => $to,
                'message' => $message,
                'name' => $name,
            ]);
            
        $this->mailer->send($email);
    }
}