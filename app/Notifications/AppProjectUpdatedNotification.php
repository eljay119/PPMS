<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class AppProjectUpdatedNotification extends Notification
{
    use Queueable;

    protected $message;
    protected $link;

    public function __construct($message, $link)
    {
        $this->message = $message;
        $this->link = $link;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->message,
            'link' => $this->link,
        ];
    }
}