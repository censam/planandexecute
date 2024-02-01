<?php

namespace App\Http\Livewire\Components;

use App\Models\ChatUser;
use App\Models\KeyResult;
use App\Models\Objective;
use App\Models\Scorecard;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Builder;

class HeaderNotifications extends Component
{
    public $unreadMessagesCount;
    public $lastActivity;
    public $isAdmin;
    public $unreadMessageData;
    public $current_team;
    public $user_id;
    public $objective_notifications;
    public $scorecards_notifications;
    public $keyresults_notifications;
    public $not_approved_objectives;
    public $loaded_route;
    public $loaded_route_id;

    protected $listeners = ['notificationHeaderUpdate' => 'render'];


    public function mount()
    {
        // $this->unreadMessages();
        $this->isAdmin = auth()->user()->hasTeamPermission(auth()->user()->currentTeam, 'objectives:read-all');
        $this->current_team = $current_team =  auth()->user()->currentTeam;
        $this->user_id = auth()->user()->id;
        $this->objective_notifications = array();
        $this->scorecards_notifications = array();
        $this->keyresults_notifications = array();
        $this->loaded_route = Route::currentRouteName();


        if (isset(Route::current()->parameters['id'])) {
            $this->loaded_route_id = Route::current()->parameters['id'];
        } else {
            $this->loaded_route_id = null;
        }
    }


    public function editObjective($id)
    {
        $this->emit('editObjective', $id);
    }


    public function unreadMessages()
    {
        $this->current_team = $current_team =  auth()->user()->currentTeam;
        //
        $this->unreadMessageData =  ChatUser::query()
            ->where('team_id', $current_team->id)
            ->whereHas('objectives', function (Builder $query) {
                $query->where('team_id', $this->current_team->id);
            })
            ->where('to_user_id', auth()->user()->id)
            ->when(($this->loaded_route == 'user.show'), function ($query) {
                $query->whereHas('objectives', function (Builder $query) {
                    $query->where('user_id',  $this->loaded_route_id);
                });
            })
            ->groupBy('type_id', 'type', 'from_user_id')
            ->orderBy('id', 'desc')->limit(15)->get();

        $this->unreadMessagesCount = $this->unreadMessageData->count();
        // dd($this->unreadMessageData);
    }

    /*
    public function unreadMessages()
    {
        $this->current_team = $current_team =  auth()->user()->currentTeam;
        $this->unreadMessageData =  array();
        // $this->unreadCount = $data->unread_messages_count;

        $unreadMsgData =  Objective::query()
        ->when((!$this->isAdmin), function ($query) {
            $query->where('user_id',auth()->user()->id);
        })
        ->withCount(['chat_messages as unread_messages_count' => function (Builder $query) {
                $query->where('is_read', 0)->where('user_id','!=',auth()->user()->id);
                }])
        ->whereIn('status', ['1', '0'])
        ->where('team_id', $this->current_team->id)
        // ->limit(30)
        ->get();

    $i=0;
    $j=0;
    $unreadMessageData =  array();
    foreach ($unreadMsgData as $key => $unreadMsg) {
        if($unreadMsg->unread_messages_count){
            if($i<5){
                $unreadMessageData[] =  $unreadMsg;
            }
            $i++;$j++;
        }
    }

    $this->unreadMessagesCount = $j;
    $this->unreadMessageData = $unreadMessageData;

    $this->lastActivity = Activity::all()->last();
    }

    */

    public function loadLatestActivity($type, $limit = 5)
    {
        // dd($this->isAdmin);
        $today = date('Y-m-d h:i:s');
        $to = date('Y-m-d h:i:s', strtotime("$today +1 day"));
        $from = date('Y-m-d h:i:s', strtotime("$to -14 days"));
        // dd($to);
        return  Activity::query()
            ->where('log_name', $type)
            ->whereHas('subject', function (Builder $query) {
                $query->where('team_id', $this->current_team->id);
            })
            ->when((!$this->isAdmin), function ($query) use ($type) {

                $query->where('causer_id', $this->user_id);
                if ($type == 'objectives') {
                    $query->whereHasMorph('subject', [Objective::class], function (Builder $query) {
                        $query->where('user_id', $this->user_id)->whereIn('status', [1]);
                    });
                }

                // if($type=='scorecards'){
                //     $query->whereHasMorph('subject',[Scorecard::class],function (Builder $query) {
                //         $query->where('user_id', $this->user_id);
                //     });
                // }


                // if($type=='keyresults'){
                //     $query->whereHasMorph('subject',[KeyResult::class],function (Builder $query) {
                //         $query->where('user_id', $this->user_id)->whereIn('status',[1,0,7]);
                //     });
                // }

                // $query->whereHasMorph('subject',[KeyResult::class,Scorecard::class],function (Builder $query) {
                //     $query->where('owner_id', $this->user_id)->whereIn('status',[1,0,7]);
                // });
            })



            ->whereBetween('created_at', [$from, $to])
            ->orderBy('updated_at', 'desc')->limit($limit)->get();
    }

    public function readNow($id)
    {
        $this->emitTo('objectives', 'searchTrigger', $id);
    }

    public function  openScorecard($id)
    {
        $this->emitTo('scorecard', 'searchTrigger', $id);
    }

    public function  openObjective($id)
    {
        //once click on notification , send notification to search bar to filter the objective
        $activity = Activity::findOrFail($id);
        $this->emitTo('objectives', 'showTrigger', $activity->subject->id);
    }

    public function  openReviewObjective($id)
    {
        //once click on notification , send notification to search bar to filter the objective

        $this->emitTo('objectives', 'reviewTrigger', $id);
    }



    public function  openKeyResult($id)
    {
        $activity = Activity::findOrFail($id);
        $this->emitTo('objectives', 'showTriggerKeyResult', $activity->id);
    }


    public function render()
    {
        $this->unreadMessages();

        // $this->loadLatestActivity('keyresults');

        $this->not_approved_objectives = Objective::where('team_id', $this->current_team->id)->where('status', 5)->where('parent_id', '!=', 0)->get();


        $this->objective_notifications = $this->loadLatestActivity('objectives', 6);
        $this->scorecards_notifications = $this->loadLatestActivity('scorecards', 6);
        $this->keyresults_notifications = $this->loadLatestActivity('keyresults', 6);
        // dd( $this->keyresults_notifications);


        $all_messages_count = $this->objective_notifications->count() + $this->scorecards_notifications->count() + $this->keyresults_notifications->count();
        // $all_messages_count = 0;

        // $this->loadLatestActivity('scorecards');
        // $this->loadLatestActivity('scorecards_history');

        return view('livewire.components.header-notifications', compact('all_messages_count'));
    }
}
