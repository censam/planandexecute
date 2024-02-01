<?php

namespace App\Console\Commands;

use App\Models\ChatBox;
use App\Models\ChatUser;
use App\Notifications\UnreadChatNotification;
use Illuminate\Console\Command;
use Notification;

class UnreadChat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'unread-chat:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Simple Notification for Unread Chats Within a day only one';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //
        //get all is_read 0  objectives
        //arrange according to descending order
        // group by to avoid send duplicate emails for one objective
        // send mails if only 1 day late --- daily
        // Mail notifications send in two ways





        $from = date('Y-m-d h:i:s',strtotime("+1 day"));

        // dd($from);
        // $chatBox =  ChatBox::where('is_read',0)
        // ->where('created_at', '<=', $from)
        // ->orderBy('id','DESC')
        // ->groupBy('type_id','type','user_id')
        // ->get();
        // $chatBox = ChatUser::where('read',0)
        //             ->where('created_at', '<=', $from)
        //             ->groupBy('type_id','type','from_user_id','to_user_id','chat_id')
        //             ->orderBy('id','asc')->get();

        // foreach ($chatBox as $key => $chat) {
        //     if($chat->type == 'objectives'){

        //         if(isset($chat->objectives)){
        //             // var_dump($chat->chatbox->content);
        //             $messages[$chat->to_user_id][$chat->type_id]['messages'][] = $chat->chatbox->content;
        //             // Notification::send($chat->toUser, new UnreadChatNotification($chat));
        //         }

        //     }

        // }


        $emailchatBox = ChatUser::where('read',0)
                    ->where('created_at', '<=', $from)
                    ->groupBy('to_user_id')
                    ->orderBy('id','asc')->get();

        foreach ($emailchatBox as  $emailChat) {
            // $contentList = array();
            // foreach($emailChat->toUser->chat_messages as $messages){

                // $contentList[$messages->chatbox->type][$messages->chatbox->type_id][$messages->from_user_id][]['content'] = $messages->chatbox->content;
                // $contentList[$messages->chatbox->type][$messages->chatbox->type_id][$messages->from_user_id]['name']= $messages->fromUser->name;
                // $contentList[$messages->chatbox->type][$messages->chatbox->type_id]['name'] = $messages->chatbox->objectives->name;
                // $contentList[$messages->chatbox->type][$messages->chatbox->type_id][]['content'] = $messages->chatbox->content;

                // .'--'.$messages->chatbox->objectives->name.'--'.$emailChat->toUser->name
             // var_dump($messages->chatbox->content.'--'.$messages->chatbox->objectives->name.'--'.$emailChat->toUser->name);


            // }

            // $emailChat->contentList = $contentList;





            Notification::send($emailChat->toUser, new UnreadChatNotification($emailChat));

        }



    }
}
