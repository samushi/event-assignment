<?php

namespace App\Domain\Event\Notifications;

use App\Domain\Auth\Models\User;
use App\Domain\Event\Models\Event;
use App\Support\EmailNotificationAbstract;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\HtmlString;

class InvitedCanceled extends EmailNotificationAbstract
{
    public function __construct(
        public readonly User $user,
        public readonly Event $event
    ) {
    }

    protected function template(): MailMessage
    {
        $message = sprintf(
            "We regret to inform you that the invitation to the '%s' event, originally scheduled for %s, has been canceled. We apologize for any inconvenience this may cause and appreciate your understanding.",
            $this->event->title,
            $this->event->event_date->format('F j, Y, g:i a')
        );

        return (new MailMessage())
            ->subject(__('Cancellation: :event', ['event' => $this->event->title]))
            ->greeting(__('Dear :firstname :lastname', ['firstname' => $this->user->first_name, 'lastname' => $this->user->last_name]))
            ->line(new HtmlString($message))
            ->line(__('Should you have any questions or require further assistance, please do not hesitate to contact us.'))
            ->salutation(__('Sincerely, The :companyName Team', ['companyName' => 'TinkerListTV']));
    }
}
