<?php

namespace App\Notifications;

use App\Models\Offer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OfferMade extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    // the parameter defined in this way, this is a shorthand syntax to define a field in a class and initialize it through the constructor
    // That's the thing you do so often that the recent PHP version has this shortcut 
    public function __construct(private Offer $offer) 
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array 
    //Specifies how this notification should be delivered to the user. You can specify one or multiple delivery channels. This is for example, 'mail' or 'database'.
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage //Specify how to convert this notification class to an email.
    {
        return (new MailMessage)
            ->line("New offer ({$this->offer->amount}) was made for your listing")
            ->action('See Your Listing', route('realtor.listing.show',['listing' => $this->offer->listing_id]))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array //Specify what data would you like to save to the database
    {
        return [
            'offer_id' => $this->offer->id,
            'listing_id' => $this->offer->listing_id,
            'amount' => $this->offer->amount,
            'bidder_id' => $this->offer->bidder_id
        ];
    }
}
