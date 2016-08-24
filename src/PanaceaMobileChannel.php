<?php

namespace NotificationChannels\PanaceaMobile;

use Illuminate\Notifications\Notification;
use NotificationChannels\PanaceaMobile\Events\SendingMessage;
use NotificationChannels\PanaceaMobile\Events\MessageWasSent;

class PanaceaMobileChannel
{
    /** @var \NotificationChannels\PanaceaMobile\PanaceaMobileApi */
    protected $panacea;

    public function __construct(PanaceaMobileApi $panacea)
    {
        $this->panacea = $panacea;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed    $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     *
     * @throws  \NotificationChannels\PanaceaMobile\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        if (! $this->shouldSendMessage($notifiable, $notification)) {
            return;
        }

        if (! $to = $notifiable->routeNotificationFor('panaceamobile')) {
            return;
        }

        $message = $notification->toPanaceaMobile($notifiable);

        if (is_string($message)) {
            $message = new PanaceaMobileMessage($message);
        }

        $this->panacea->send($to, $message->toArray());

        event(new MessageWasSent($notifiable, $notification));
    }

    /**
     * Check if we can send the notification.
     *
     * @param      $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @return bool
     */
    protected function shouldSendMessage($notifiable, Notification $notification)
    {
        return event(new SendingMessage($notifiable, $notification), [], true) !== false;
    }
}
