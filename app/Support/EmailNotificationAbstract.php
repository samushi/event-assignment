<?php

namespace App\Support;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

abstract class EmailNotificationAbstract extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Send via.
     *
     * @return string[]
     */
    public function via(): array
    {
        return ['mail'];
    }

    /**
     * Sent email
     */
    public function toMail(): MailMessage
    {
        return $this->template();
    }

    /**
     * Sent email template.
     */
    abstract protected function template(): MailMessage;
}
