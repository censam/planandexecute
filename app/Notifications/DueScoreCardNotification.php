<?php

namespace App\Notifications;

use App\Models\Team;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DueScoreCardNotification extends Notification
{
    use Queueable;
    private $scorecardData;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($scorecardData)
    {
        $this->scorecardData = $scorecardData;
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
        $scorecardTeam = Team::find($this->scorecardData->team_id);

        $dueDate = (($this->scorecardData->oldestHistory->due_date)? date('d-M-y', strtotime($this->scorecardData->oldestHistory->due_date)) :'---');
        // $this->scorecardData->oldestHistory->note
        return (new MailMessage)
                    ->subject(ucwords($this->scorecardData->title).' Due On '.$dueDate.'.')
                    ->greeting('Hello, '.ucwords($this->scorecardData->user->name).'!')
                    ->line('The Scorecard in "'.$scorecardTeam->name.'" is Due On '.$dueDate.'.')
                    ->action('View Scorecard', url('/scorecards'))
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
            //
        ];
    }
}
