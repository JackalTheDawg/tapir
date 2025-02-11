<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Orchid\Platform\Notifications\DashboardChannel;
use Orchid\Platform\Notifications\DashboardMessage;

use App\Models\Acceptance;

class FailedCrmRequest extends Notification
{
    use Queueable;

    public Acceptance $data;

    /**
     * Create a new notification instance.
     */
    public function __construct(Acceptance $data)
    {
     $this -> data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [DashboardChannel::class];
    }

    public function toDashboard($notifiable){
        return (new DashboardMessage)
            -> title('Ошибка отправки в CRM')
            -> message("Телефон: ". $this -> data -> phone." / VIN: ". $this -> data -> car -> vin)
            -> action(route("platform.resend", ["phone" => $this -> data -> phone, "vin" => $this -> data -> car -> vin]));
    }
}
