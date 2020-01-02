<?php

namespace App\Notifications\Task;

use App\Constants\NotificationActionConstants;
use App\Traits\NexmoTrait;
use App\Traits\NotificationTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;

class UpdatedTask extends Notification implements ShouldQueue
{
    use Queueable;
    use NexmoTrait;
    use NotificationTrait;

    public $task;
    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($task, $user)
    {
        $this->task = $task;
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
        return $this->buildActions(NotificationActionConstants::ACTION_LOGIN_NAME);
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
            ->subject('Updated Task Success')
            ->greeting('Hello,'. $this->user->getFirstName() . '!'.trans('auth.test'))
            ->line('You updated task success!')
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
            'action' => NotificationActionConstants::ACTION_CREATED_TASK_NAME,
            'data' => ['task' => $this->task, 'user' => $this->user],
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
        $message = trans('auth.test') . ' You updated task success! Thank you for using our application!';
        return (new NexmoMessage)
            ->content($message);
    }
}
