<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatUser extends Model
{
    use HasFactory;

    protected $fillable = ['chat_id','to_user_id','from_user_id','team_id','type','type_id','read'];


    public function toUser()
    {
        return $this->belongsTo(User::class,'to_user_id');
    }

    public function fromUser()
    {
        return $this->belongsTo(User::class,'from_user_id');
    }

    public function chatbox()
    {
        return $this->belongsTo(ChatBox::class,'chat_id');
    }

    public function objectives()
    {
        return $this->belongsTo(Objective::class,'type_id');
    }


    public function scorecards()
    {
        return $this->belongsTo(Scorecard::class,'type_id');
    }
}

