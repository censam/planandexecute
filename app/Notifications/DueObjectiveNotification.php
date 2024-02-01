<?php

namespace App\Notifications;

use App\Models\Objective;
use App\Models\Team;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Http\Traits\PushNotificationsTrait;
use Illuminate\Support\Str;

class DueObjectiveNotification extends Notification
{
    use Queueable;
    use PushNotificationsTrait;
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
        $user = ucwords($notifiable->name);
        $from = date('Y-m-d h:i:s',strtotime("3 days"));
        $all_due_objectives_by_user = Objective::whereIn('status',['1','0'])->whereIn('completed',['0','2'])
        // ->whereBetween('due_date',[$from, $to])
        ->where('due_date', '<=', $from)
        ->where('user_id', $notifiable->id)
        ->orderBy('due_date','DESC')
        ->get();

        $subject = 'You have ('.$all_due_objectives_by_user->count().') due '.Str::plural('objectives', $all_due_objectives_by_user->count());


        if($notifiable->device_id){


        $pushBody = '';
        foreach ($all_due_objectives_by_user as $objective) {
            $pushBody.= Str::limit($objective->name,60,' ...').' - ('.($objective->team->name??"--").') -'.' Due On :  '.(($objective->due_date)? date("d-M-y", strtotime($objective->due_date)) :'---').'\\n'; //
        }

        $res = $this->sendPushNotification($notifiable->device_id, $subject, $pushBody, $notifiable->id,'objective');

    }


        return (new MailMessage)
        ->subject('[Due Objectives]-'.$subject)
        ->markdown(
            'vendor.notifications.due-objectives',['user'=>$user,'objectives'=>$all_due_objectives_by_user,'subject'=>$subject]
        );

     /*   $objectiveTeam = Team::find($this->objectiveData->team_id);

        $objective = Objective::query()
            ->withCount(['other_key_results as completed_key_result_count' => function ($query) {
                $query->where('completed', 1);
        }])
        ->where('id' ,$this->objectiveData->id)
            ->first();


        $this->objectiveData->completed_key_result_count = $objective->completed_key_result_count;

        $dueDate = (($this->objectiveData->due_date)? date('d-M-y', strtotime($this->objectiveData->due_date)) :'---');


        $url = url('/objectives/'.$this->objectiveData->id);

        return (new MailMessage)
        ->subject('[Objective]-'.$this->objectiveData->name.' - Due On '.$dueDate)
        ->markdown(
            'vendor.notifications.due-objectives-copy',['objective'=>$this->objectiveData,'url' => $url,'team_name'=>$objectiveTeam,'due_date'=>$dueDate]
        );

        */

    }


}
