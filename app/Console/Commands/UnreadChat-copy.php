<?php

namespace App\Console\Commands;

use App\Models\ChatBox;
use App\Notifications\UnreadChatNotification;
use Illuminate\Console\Command;
use Notification;

class UnreadChatee extends Command
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
        $chatBox =  ChatBox::where('is_read',0)
        ->where('created_at', '<=', $from)
        ->orderBy('id','DESC')
        ->groupBy('type_id','type','user_id')
        ->get();


        foreach ($chatBox as $key => $chat) {

            if($chat->type == 'objectives'){


                if(isset($chat->objectives)){

                    //FIRST ONE
                    //First Find Objective id and its user_id
                    //then check this message written by this objective_user_id
                    //if not send him (objective owner) message. $chat->objectives->user_id
                    // dd($chat->content);
                    // dd($chat);
                    $contentList = ChatBox::where('type_id',$chat->type_id)->where('type',$chat->type)->where('is_read',0)->get();

                    $chat->contentList = $contentList->pluck('content');
                    // var_dump('--');

                    if($chat->objectives->user_id!=$chat->user_id){

                        // dd($chat->objectives->name);
                        // var_dump('mail send to objective owner');
                        Notification::send($chat->objectives->user, new UnreadChatNotification($chat));

                    }else{

                        //SECOND ONE
                        //Check thiss user message with previous records id and
                        //send that message to the previous  chat user.
                        $opposite_user_message = ChatBox::where('type_id',$chat->type_id)->where('type',$chat->type)->where('user_id','!=',$chat->user_id)->latest()->first();

                        if($opposite_user_message){
                            // dd($opposite_user_message->user);
                            if($chat->objectives->user_id!=$chat->user_id){
                                Notification::send($opposite_user_message->user, new UnreadChatNotification($chat));
                            }


                        // var_dump('mail send to opposite messenger');

                        }

                    }





                }






            }
            // exit;

            // print_r('--------------------------------');

        }

    }
}
