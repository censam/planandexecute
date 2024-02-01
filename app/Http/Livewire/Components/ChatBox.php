<?php

namespace App\Http\Livewire\Components;

use App\Models\ChatBox as ModelsChatBox;
use App\Models\ChatUser;
use App\Models\Objective;
use Livewire\Component;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Emoji\Emoji;

class ChatBox extends Component
{
    // public $entityId;
    // public string $field; // this is can be column. It comes from the blade-view foreach($fields as $field)
    // public string $model; // Eloquent model with full name-space
    public $isOpen;
    public Model $model;
    public $type;
    public $type_id;
    public $user_id;
    public $content;
    public $unreadCount;
    public $allCount;
    public $emoji_set;
    public $recordCount;
    public $currentTeam;


    protected $listeners = ['openChatByNotification'];

    public function mount($model)
    {
        // dd('hello');
        $this->type_id = $this->model->id;
        $this->type = $this->model->getTable();
        $this->isOpen = false;
        $this->user_id =  auth()->user()->id;
        $this->emoji_set = $this->initEmoji();
        $this->recordCount = 10;
        $this->currentTeam = auth()->user()->currentTeam;
        // dd($this->currentTeam);
    }


    public function openChatByNotification($id)
    {

        if ($this->type_id == $id) {
            $this->openChat();
        }
    }


    public function addEmoji($emoji)
    {

        $this->content = $this->content . ' ' . $emoji . ' ';
    }

    public function unread()
    {
        $data =  $this->model->where('id', $this->model->id)
            ->withTrashed()->withCount(
                ['chat_messages as unread_messages_count' => function (Builder $query) {
                    $query->where('is_read', 0)->where('user_id', '!=', $this->user_id);
                }],
                ['chat_messages as all_messages_count' => function (Builder $query) {
                }]
            )->first();

        $this->unreadCount = ChatUser::where('type_id', $this->type_id)
            ->where('type', $this->type)
            ->where('to_user_id', $this->user_id)->count();

        // $this->unreadCount = $data->unread_messages_count;
        if (isset($data->chat_messages)) {
            $this->allCount = $data->chat_messages->count();
        } else {
            $this->allCount = 0;
        }
    }

    public function sendMessage()
    {

        $messages = [
            'content.required' => 'Please fill nudge text field here.',
            'content.min' => 'It should be more than 2 characters.',
        ];

        $this->validate([
            'content' => 'required|min:2',
        ], $messages);


        $chat = ModelsChatBox::create([
            'user_id' => $this->user_id,
            'type_id' => $this->type_id,
            'type' => $this->type,
            'is_read' => 0,
            'content' => nl2br($this->content),
        ]);


        $this->addToChatNotification($chat);

        $this->reset('content');

        $this->dispatchBrowserEvent('messagebox_scrolled');
    }


    public function addToChatNotification($chat)
    {

        if ($this->model->objective_type == '0') {
            //if a individual objective, notification create with whole 'Main Team'

            foreach ($this->currentTeam->allUsers() as $key => $team_member) {
                if ($team_member->id != $this->user_id) {

                    if ($team_member->hasTeamRole($this->currentTeam, 'admin') || $team_member->hasTeamRole($this->currentTeam, 'super_admin') || ($team_member->id == $this->model->user_id)) {
                        ChatUser::create([
                            'chat_id' => $chat->id,
                            'to_user_id' => $team_member->id,
                            'from_user_id' => $this->user_id,
                            'team_id' => $this->currentTeam->id,
                            'type_id' => $this->type_id,
                            'type' => $this->type,
                            'read' => 0
                        ]);
                    }
                }
            }
        } else {
            //if a team objective create notification only with objective-team
            // $allowed_users = $this->model->allowed_users;

            $allowed_users_arr = explode(',', $this->model->allowed_users);
            $allowed_users_arr_unique = array_unique($allowed_users_arr);
            foreach ($allowed_users_arr_unique as $user_id) {
                if ($this->user_id != $user_id) {

                    ChatUser::create([
                        'chat_id' => $chat->id,
                        'to_user_id' => $user_id,
                        'from_user_id' => $this->user_id,
                        'team_id' => $this->currentTeam->id,
                        'type_id' => $this->type_id,
                        'type' => $this->type,
                        'read' => 0
                    ]);
                }
            }
        }
    }

    public function loadChat()
    {
        $this->recordCount += 10;
    }

    public function openChat()
    {

        $this->isOpen = true;
        $this->updateAsread();
    }


    public function updateAsread()
    {

        ChatUser::where('type_id', $this->type_id)
            ->where('type', $this->type)
            ->where('to_user_id', $this->user_id)
            ->delete();
    }

    public function closeChat()
    {
        $this->isOpen = false;
        $this->recordCount = 10;
        $this->emit('notificationHeaderUpdate');
        $this->emitTo('objectives', 'clearsearch');
    }

    public function render()
    {

        $this->unread();

        $messages = ModelsChatBox
            ::where('type', $this->type)
            ->where('type_id', $this->type_id)
            ->latest()
            ->take($this->recordCount)
            ->get()
            ->sortBy('id');
        return view('livewire.components.chat-box', compact('messages'));
    }


    public function initEmoji()
    {

        return  [
            Emoji::CHARACTER_GRINNING_FACE,
            Emoji::CHARACTER_GRINNING_FACE,
            Emoji::CHARACTER_GRINNING_FACE_WITH_BIG_EYES,
            Emoji::CHARACTER_GRINNING_FACE_WITH_SMILING_EYES,
            Emoji::CHARACTER_BEAMING_FACE_WITH_SMILING_EYES,
            Emoji::CHARACTER_GRINNING_SQUINTING_FACE,
            Emoji::CHARACTER_GRINNING_FACE_WITH_SWEAT,
            Emoji::CHARACTER_ROLLING_ON_THE_FLOOR_LAUGHING,
            Emoji::CHARACTER_FACE_WITH_TEARS_OF_JOY,
            Emoji::CHARACTER_SLIGHTLY_SMILING_FACE,
            Emoji::CHARACTER_UPSIDE_DOWN_FACE,
            Emoji::CHARACTER_WINKING_FACE,
            Emoji::CHARACTER_SMILING_FACE_WITH_SMILING_EYES,
            Emoji::CHARACTER_SMILING_FACE_WITH_HALO,
            Emoji::CHARACTER_SMILING_FACE_WITH_HEARTS,
            Emoji::CHARACTER_SMILING_FACE_WITH_HEART_EYES,
            Emoji::CHARACTER_STAR_STRUCK,
            Emoji::CHARACTER_FACE_BLOWING_A_KISS,
            Emoji::CHARACTER_KISSING_FACE,
            // Emoji::CHARACTER_SMILING_FACE,
            Emoji::CHARACTER_KISSING_FACE_WITH_CLOSED_EYES,
            Emoji::CHARACTER_KISSING_FACE_WITH_SMILING_EYES,
            // Emoji::CHARACTER_SMILING_FACE_WITH_TEAR,
            Emoji::CHARACTER_FACE_SAVORING_FOOD,
            Emoji::CHARACTER_FACE_WITH_TONGUE,
            Emoji::CHARACTER_WINKING_FACE_WITH_TONGUE,
            Emoji::CHARACTER_ZANY_FACE,
            Emoji::CHARACTER_SQUINTING_FACE_WITH_TONGUE,
            Emoji::CHARACTER_MONEY_MOUTH_FACE,
            Emoji::CHARACTER_HUGGING_FACE,
            Emoji::CHARACTER_FACE_WITH_HAND_OVER_MOUTH,
            Emoji::CHARACTER_SHUSHING_FACE,
            Emoji::CHARACTER_THINKING_FACE,
            Emoji::CHARACTER_FACE_WITH_MEDICAL_MASK,
            Emoji::CHARACTER_FACE_WITH_THERMOMETER,
            Emoji::CHARACTER_SMILING_FACE_WITH_SUNGLASSES,
            Emoji::CHARACTER_ANGRY_FACE,
            Emoji::CHARACTER_ANGRY_FACE_WITH_HORNS,
            Emoji::CHARACTER_SEE_NO_EVIL_MONKEY,
            Emoji::CHARACTER_KISS_MARK,
            Emoji::CHARACTER_SPARKLING_HEART,
            Emoji::CHARACTER_WAVING_HAND,
            Emoji::CHARACTER_RAISED_BACK_OF_HAND,
            Emoji::CHARACTER_HAND_WITH_FINGERS_SPLAYED,
            Emoji::CHARACTER_RAISED_HAND,
            Emoji::CHARACTER_VULCAN_SALUTE,
            Emoji::CHARACTER_OK_HAND,
            // Emoji::CHARACTER_PINCHED_FINGERS,
            Emoji::CHARACTER_PINCHING_HAND,
            Emoji::CHARACTER_VICTORY_HAND,
            Emoji::CHARACTER_CROSSED_FINGERS,
            Emoji::CHARACTER_LOVE_YOU_GESTURE,
            Emoji::CHARACTER_SIGN_OF_THE_HORNS,
            Emoji::CHARACTER_CALL_ME_HAND,
            Emoji::CHARACTER_MIDDLE_FINGER,
            Emoji::CHARACTER_BACKHAND_INDEX_POINTING_DOWN,
            Emoji::CHARACTER_INDEX_POINTING_UP,
            Emoji::CHARACTER_THUMBS_UP,
            Emoji::CHARACTER_THUMBS_DOWN,
            Emoji::CHARACTER_RAISED_FIST,
            Emoji::CHARACTER_ONCOMING_FIST,
            Emoji::CHARACTER_CLAPPING_HANDS,
            Emoji::CHARACTER_RAISING_HANDS,
            Emoji::CHARACTER_OPEN_HANDS,
            Emoji::CHARACTER_PALMS_UP_TOGETHER,
            Emoji::CHARACTER_HANDSHAKE,
            Emoji::CHARACTER_FOLDED_HANDS,
            Emoji::CHARACTER_WRITING_HAND,
            Emoji::CHARACTER_SELFIE,
            Emoji::CHARACTER_NAIL_POLISH,
            Emoji::CHARACTER_FLEXED_BICEPS,
            Emoji::CHARACTER_KNOCKED_OUT_FACE,
            Emoji::CHARACTER_LEG,
            Emoji::CHARACTER_FOOT,
            Emoji::CHARACTER_BABY,
            Emoji::CHARACTER_CHILD,
            Emoji::CHARACTER_BOY,
            Emoji::CHARACTER_GIRL,
            Emoji::CHARACTER_PERSON,
            Emoji::CHARACTER_WOMAN,
            Emoji::CHARACTER_OLD_MAN,
            Emoji::CHARACTER_MONEY_BAG,
            Emoji::CHARACTER_BAR_CHART,
            Emoji::CHARACTER_SCISSORS,
            Emoji::CHARACTER_CALENDAR,
            Emoji::CHARACTER_E_MAIL,
            Emoji::CHARACTER_CREDIT_CARD,
        ];
    }
}
