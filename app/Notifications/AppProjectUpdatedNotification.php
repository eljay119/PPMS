<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class AppProjectUpdatedNotification extends Notification
{
    use Queueable;

    protected $appProject;

    public function __construct($appProject)
    {
        $this->appProject = $appProject;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "APP Project '{$this->appProject->title}' was updated.",
            'link' => route('head.app_projects.show', $this->appProject->id),
        ];
    }
}