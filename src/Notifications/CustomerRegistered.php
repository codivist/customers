<?php

namespace Codivist\Modules\Customers\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Codivist\Modules\Customers\Models\Customer;

class CustomerRegistered extends Notification
{
    use Queueable;

    /**
     * The customer instance.
     *
     * @var Order
     */
    public $customer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
                    ->line(__('Your account has been created, now you need to activate it.'))
                    ->action(__('Activate my account'), route('activate', $this->customer->token));
    }
}
