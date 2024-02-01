<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Http\Traits\PushNotificationsTrait;
use Illuminate\Support\Str;

class UnreadChatNotification extends Notification
{
    use Queueable;
    use PushNotificationsTrait;
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
        $subject =  'You have unread messages about these Objectives';
        $user = ucwords($notifiable->name);
        $chat = $this->chatData;

        if($notifiable->device_id){
            $pushBody = '';
            foreach ($chat->toUser->chat_messages as $message) {
                if($message->objectives){
                    $pushBody.= Str::limit(($message->objectives->name??'--'),150,' ...').' - ('.($message->objectives->team->name??"--").')';// ectives->team->name??'--')}})</h2><span></span> <br> <div style="border-radius:50%;display:inline-flex"> <img src="{{$message->fromUser->profile_photo_url}}" border="1" style="border-radius:50%;display:block;object-fit:cover"  width="30" height="30">  </span> <span style="border-radius:10px; border-bottom-left-radius:0px; color: white; margin-left: 10px;padding:6px;background-color: rgba(56, 60, 70, 0.5)">{!! $message->chatbox->content !!}</span>     | <h5>  <a target="_blank" href=" {{url('/objectives/'.$message->objectives->id)}}"> <span class="button button-green"  style="font-size: 12px; box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; top:6px; -webkit-text-size-adjust: none; border-radius: 16px; color: white; display: inline-block; overflow: hidden; text-decoration: none; background-color: #6ee2bb; border-bottom: 2px solid #5fdf98; border-left: 6px solid #5fdf98; border-right: 6px solid #5fdf98; border-top: 2px solid #5fdf98;"> View </span></a></h5>
                }
            }

            $res = $this->sendPushNotification($notifiable->device_id, 'You have unread messages..', $pushBody, $notifiable->id,'chat');

        }



        return (new MailMessage)

                    ->subject('[Chat] '.$subject)
                    ->markdown('vendor.notifications.unread_chat_messages',compact('subject','user','chat'));

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
