<?php

namespace App\Notifications\Auth;

use App\Traits\NexmoTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;

class VerificationUser extends Notification implements ShouldQueue
{
    use Queueable;
    use NexmoTrait;

    public $user;
    public $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $token)
    {
        $this->user = $user;
        $this->token = $token;
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
            ->subject('User Verification')
            ->view('mails.auth.verify', [
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
            'action' => 'VerificationUser',
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
        $message = trans('auth.test') . ' Verify User ' . $this->user->getFirstName() . ', goto link ' . env('APP_URL') . '/verify/' . $this->token;
        return (new NexmoMessage)
            ->content($message);
    }
}
