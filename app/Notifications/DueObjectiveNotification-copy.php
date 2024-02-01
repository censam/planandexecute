<?php

namespace App\Notifications;

use App\Models\Objective;
use App\Models\Team;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DueObjectiveNotification extends Notification
{
    use Queueable;
    private $objectiveData;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($objectiveData)
    {

        $this->objectiveData = $objectiveData;
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

        $objectiveTeam = Team::find($this->objectiveData->team_id);

        $objective = Objective::query()
            ->withCount(['other_key_results as completed_key_result_count' => function ($query) {
                $query->where('completed', 1);
        }])
        ->where('id' ,$this->objectiveData->id)
            ->first();


        $this->objectiveData->completed_key_result_count = $objective->completed_key_result_count;

        $dueDate = (($this->objectiveData->due_date)? date('d-M-y', strtotime($this->objectiveData->due_date)) :'---');

        // dd($this->objectiveData);
        $url = url('/objectives/'.$this->objectiveData->id);

        return (new MailMessage)
        ->subject('[Objective]-'.$this->objectiveData->name.' - Due On '.$dueDate)
        ->markdown(
            'vendor.notifications.due-objectives-copy',['objective'=>$this->objectiveData,'url' => $url,'team_name'=>$objectiveTeam,'due_date'=>$dueDate]
        );





        // return (new MailMessage)
        //             ->from('info@planandexecute.io', 'PLAN-AND-EXECUTE')
        //             ->view('vendor.notifications.due-objectives')
        //             ->level('success')
        //             ->subject('[Objective]-'.$this->objectiveData->name.' - Due On '.$dueDate)
        //             ->greeting('Hello, '.ucwords($this->objectiveData->user->name).'!')
        //             ->line('The Objective in "'.$objectiveTeam->name.'" is Due On '.$dueDate.'.')
        //             ->line($this->objectiveData->name)
        //             ->action('View Objective', url('/objectives/'.$this->objectiveData->id),'green')
        //             ->line('Thank you for using our application!');
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
            // 'objective_id' => $this->objectiveData['id']
        ];
    }
}
