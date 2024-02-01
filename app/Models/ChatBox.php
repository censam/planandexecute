<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatBox extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id','type_id','type','content','read'
    ];

//     public function getcreatedAtAttribute()
// {
//     return date('Y-m-d h:i:s',$this->createdAt); //"{$this->first_name} {$this->last_name}";
// }

    // protected $casts = [
    //     'created_at' => 'datetime:Y-m-d',
    // ];

    public function user()
    {
        return $this->belongsTo(User::class);
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
