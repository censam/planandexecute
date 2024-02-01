<?php

namespace App\Http\Controllers;

use App\Http\Livewire\Components\ChatBox as ComponentsChatBox;
use App\Http\Resources\Chatbox as ResourcesChatbox;
use App\Models\ChatBox;
use App\Models\ChatUser;
use App\Models\Objective;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Traits\PushNotificationsTrait;
use App\Models\User;
use Illuminate\Support\Str;



class ChatBoxController extends Controller
{
    use PushNotificationsTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    public function loadChat($objective_id, $count = 10)
    {
        $current_team =  auth()->user()->currentTeam;
        $current_team_id = $current_team->id;

        $objective = Objective::find($objective_id);

        $isAdmin = auth()->user()->hasTeamPermission($current_team, 'objectives:read-all');

        if ($objective) {
            if (($objective->team_id == $current_team_id) && (($isAdmin) || (auth()->user()->id == $objective->user_id))) {

                $messages = ChatBox::where('type', 'objectives')
                    ->where('type_id', $objective_id)
                    ->with('user')
                    ->latest()
                    // ->take($count)
                    // ->get()
                    // ->sortBy('id')
                    ->paginate($count);

                return new ResourcesChatbox($messages);
            } else {
                return response()->json(['message' => 'Not allow to load this nudge', 'status' => false], 401);
            }
        } else {
            return response()->json(['message' => 'Objective Not Found', 'status' => false], 404);
        }
    }



    public function sendChatMessage(Request $request)
    {
        $inputs = $request->all();

        $messages = [
            'content.required' => 'Please fill nudge text field here.',
            'content.min' => 'It should be more than 2 characters.',

        ];

        $rules = [
            'content' => 'required|min:2',
            'objective_id' => 'required',
        ];

        $validator = Validator::make($inputs, $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => false], 422);
        }

        $auth_user = auth()->user();
        $current_team =  $auth_user->currentTeam;
        $current_team_id = $current_team->id;

        $objective = Objective::find($inputs['objective_id']);
        $isAdmin = auth()->user()->hasTeamPermission($current_team, 'objectives:read-all');

        if (($objective->team_id == $current_team_id) && (($isAdmin) || (auth()->user()->id == $objective->user_id))) {

            $chat = ChatBox::create([
                'user_id' => auth()->user()->id,
                'type_id' => $inputs['objective_id'],
                'type' => 'objectives',
                'is_read' => 0,
                'content' => nl2br($inputs['content']),
            ]);

            $this->addToChatNotification($chat, $objective, $current_team, $auth_user);

            return response()->json(['data' => $chat, 'message' => 'Message Sent Successfully', 'status' => true], 200);
        } else {
            return response()->json(['message' => 'Not allow to send this message', 'status' => false], 401);
        }
    }

    public function UnreadObjectiveChatMessages($objective_id)
    {

        $unreadMessageData =  ChatUser::where('type','objectives')
            ->where('type_id', $objective_id)
            ->where('to_user_id', auth()->user()->id)
            ->with('objectives', 'toUser', 'fromUser', 'chatbox')
            // ->groupBy('type_id', 'type', 'from_user_id')
            ->orderBy('id', 'desc')->limit(15)->get();


        return new ResourcesChatbox($unreadMessageData);
    }

    public function updateAsread($objective_id)
    {

        $auth_user = auth()->user();
        ChatUser::where('type_id', $objective_id)
            ->where('type', 'objectives')
            ->where('to_user_id', $auth_user->id)
            ->delete();

        return response()->json(['message' => 'Message read Successfully', 'status' => true], 200);
    }



    public function UnreadChatMessages()
    {
        $current_team =  auth()->user()->currentTeam;
        //
        $unreadMessageData =  ChatUser::query()
            ->where('team_id', $current_team->id)
            ->whereHas('objectives', function (Builder $query) use ($current_team) {
                $query->where('team_id', $current_team->id);
            })
            ->where('to_user_id', auth()->user()->id)
            ->with('objectives', 'toUser', 'fromUser', 'chatbox')
            ->groupBy('type_id', 'type', 'from_user_id')
            ->orderBy('id', 'desc')->limit(15)->get();


        return new ResourcesChatbox($unreadMessageData);
    }


    public function addToChatNotification($chat, $objective, $current_team, $auth_user)
    {

        if ($objective->objective_type == '0') {
            //if a individual objective, notification create with whole 'Main Team'

            foreach ($current_team->allUsers() as $key => $team_member) {
                if ($team_member->id != $auth_user->id) {

                    if ($team_member->hasTeamRole($current_team, 'admin') || $team_member->hasTeamRole($current_team, 'super_admin')) {
                        ChatUser::create([
                            'chat_id' => $chat->id,
                            'to_user_id' => $team_member->id,
                            'from_user_id' => $auth_user->id,
                            'team_id' => $current_team->id,
                            'type_id' => $objective->id,
                            'type' => 'objectives',
                            'read' => 0
                        ]);

                        $this->sendChatPushNotifications($team_member->id,$auth_user, $chat, $objective);
                    }
                }
            }
        } else {
            //if a team objective create notification only with objective-team
            // $allowed_users = $this->model->allowed_users;

            $allowed_users_arr = explode(',', $objective->allowed_users);
            $allowed_users_arr_unique = array_unique($allowed_users_arr);
            foreach ($allowed_users_arr_unique as $user_id) {
                if ($auth_user->id != $user_id) {

                    ChatUser::create([
                        'chat_id' => $chat->id,
                        'to_user_id' => $user_id,
                        'from_user_id' => $auth_user->id,
                        'team_id' => $current_team->id,
                        'type_id' => $objective->id,
                        'type' => 'objectives',
                        'read' => 0
                    ]);

                    $this->sendChatPushNotifications($user_id,$auth_user, $chat, $objective);
                }
            }
        }
    }


    public function sendChatPushNotifications($to_user_id,$from_user, $chat, $objective)
    {
        $notifiable = User::find($to_user_id);
        $user = ucwords($notifiable->name);


        if ($notifiable->device_id) {
            $pushBody = '';

            $pushBody .= Str::limit(($objective->name ?? '--'), 150, ' ...') . ' - (' . ($objective->team->name ?? "--") . ') \\n'; // ectives->team->name??'--')}})</h2><span></span> <br> <div style="border-radius:50%;display:inline-flex"> <img src="{{$message->fromUser->profile_photo_url}}" border="1" style="border-radius:50%;display:block;object-fit:cover"  width="30" height="30">  </span> <span style="border-radius:10px; border-bottom-left-radius:0px; color: white; margin-left: 10px;padding:6px;background-color: rgba(56, 60, 70, 0.5)">{!! $message->chatbox->content !!}</span>     | <h5>  <a target="_blank" href=" {{url('/objectives/'.$message->objectives->id)}}"> <span class="button button-green"  style="font-size: 12px; box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; top:6px; -webkit-text-size-adjust: none; border-radius: 16px; color: white; display: inline-block; overflow: hidden; text-decoration: none; background-color: #6ee2bb; border-bottom: 2px solid #5fdf98; border-left: 6px solid #5fdf98; border-right: 6px solid #5fdf98; border-top: 2px solid #5fdf98;"> View </span></a></h5>
            $pushBody .= ucwords($from_user->name)." : ".$chat->content;


            $res = $this->sendPushNotification($notifiable->device_id, 'You have unread messages..', $pushBody, $notifiable->id, 'chat');
        }
    }

    public function loadChatHistory($objective_id, $count)
    {
        $count = $count * 10;
        return $this->loadChat($objective_id, $count);
    }



    public function checkObjectiveTeam($objective_id)
    {
        $current_team =  auth()->user()->currentTeam;
        $current_team_id = $current_team->id;

        $objective = Objective::find($objective_id);

        if ($objective) {
        } else {
            return false;
        }
    }


    public function loadEmoji()
    {
        $componentChatBox = new ComponentsChatBox();
        return $componentChatBox->initEmoji();
    }





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ChatBox  $chatBox
     * @return \Illuminate\Http\Response
     */
    public function show(ChatBox $chatBox)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChatBox  $chatBox
     * @return \Illuminate\Http\Response
     */
    public function edit(ChatBox $chatBox)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ChatBox  $chatBox
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChatBox $chatBox)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChatBox  $chatBox
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChatBox $chatBox)
    {
        //
    }
}
