<?php

namespace App\Notifications\Auth;

use App\Constants\NotificationActionConstants;
use App\Traits\NexmoTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;

class ForgotPasswordUser extends Notification implements ShouldQueue
{
    use Queueable;
    use NexmoTrait;

    public $user;
    public $token;
    public $field;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $token, $field)
    {
        $this->user = $user;
        $this->token = $token;
        $this->field = $field;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', 'nexmo'];
        //return $this->field == 'email' ? ['mail', 'database'] : ['database', 'nexmo'];
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
            ->subject('Forgot Password')
            ->view('mails.auth.forgot-password', [
                'user' => $this->user,
                'token' => $this->token
            ]);
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
            'action' => NotificationActionConstants::ACTION_FORGOT_PASSWORD_NAME,
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
        $message = trans('auth.test') . ($this->field == 'email' ? ' Forgot Password, goto link ' . env('APP_URL') . '/reset-password/'
                                                                    :  ' Code for reset Password - ') . $this->token;
        return (new NexmoMessage)
            ->content($message);
    }
}
