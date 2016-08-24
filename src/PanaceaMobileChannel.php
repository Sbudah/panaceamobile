<?php

namespace NotificationChannels\PanaceaMobile;

use Illuminate\Notifications\Notification;

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

        if (! $to = $notifiable->routeNotificationFor('panaceamobile')) {
            return;
        }

        $message = $notification->toPanaceaMobile($notifiable);

        if (is_string($message)) {
            $message = new PanaceaMobileMessage($message);
        }

        $this->panacea->send($to, $message->toArray());
    }
}
