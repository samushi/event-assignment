<?php

namespace App\Domain\Event\Notifications;

use App\Domain\Auth\Models\User;
use App\Domain\Event\Models\Event;
use App\Support\EmailNotificationAbstract;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\HtmlString;

class Invited extends EmailNotificationAbstract
{
    public function __construct(
        public readonly User $user,
        public readonly Event $event
    )
    {
    }

    protected function template(): MailMessage
    {
        $message = sprintf(
            "We are pleased to invite you to the '%s' event, scheduled for %s. This event is an excellent opportunity for networking. Detailed information about the event and your participation is attached.",
            $this->event->title,
            $this->event->event_date->format('F j, Y, g:i a')
        );

        return (new MailMessage())
            ->subject(__('Invitation: :event', ['event' => $this->event->title]))
            ->greeting(__('Dear :firstname :lastname', ['firstname' => $this->user->first_name, 'lastname' => $this->user->last_name]))
            ->line(new HtmlString($message))
            ->line(__('If you have any questions or need further information, please do not hesitate to contact us.'))
            ->salutation(__('Sincerely, The :companyName Team', ['companyName' => 'TinkerListTV']));
    }
}
