<?php

namespace App\Notifications\Auth;

use App\Constants\NotificationActionConstants;
use App\Traits\NexmoTrait;
use App\Traits\NotificationTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;

class LogoutUserSuccess extends Notification implements ShouldQueue
{
    use Queueable;
    use NexmoTrait;
    use NotificationTrait;

    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $this->buildActions(NotificationActionConstants::ACTION_LOGOUT_NAME);
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Logout User Success')
            ->greeting('Hello,'. $this->user->getFirstName() . '!'.trans('auth.test'))
            ->line('You logout success!')
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'action' => NotificationActionConstants::ACTION_LOGOUT_NAME,
            'data' => ['user' => $this->user],
        ];
    }

    /**
     * Get the Nexmo / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return NexmoMessage
     */
    public function toNexmo($notifiable)
    {
        $message = trans('auth.test') . ' You logout success! Thank you for using our application!';
        return (new NexmoMessage)
            ->content($message);
    }
}
