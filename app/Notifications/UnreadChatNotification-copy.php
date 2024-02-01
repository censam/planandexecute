<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UnreadChatNotificatioCopy extends Notification
{
    use Queueable;
    private $chatData;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($chatData)
    {
    $this->chatData = $chatData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $subject =  'You have unread messages about the Objective - '.ucwords($this->chatData->objectives->name);
        $user = ucwords($this->chatData->objectives->user->name);
        $messaged_user = ucwords($this->chatData->user->name);
        $url = url('/objectives/'.$this->chatData->objectives->id);
        $messages = $this->chatData->contentList;
        $chat = $this->chatData;
        // dd($messages);
        return (new MailMessage)
        // ->from('barrett@example.com', 'Barrett Blair')
                    ->subject('[Chat] '.$subject)
                    ->markdown('vendor.notifications.unread_chat_messages',compact('subject','user','url','messages','chat','messaged_user'));
                    // ->line( $subject)
                    // ->line( $content)
                    // ->action('Reply To Chat', url('/objectives/'.$this->chatData->objectives->id))
                    // ->line('Thank you!');
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
            //
        ];
    }
}
