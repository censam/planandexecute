<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Objective extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = [
        'user_id','team_id','name', 'description', 'due_date' , 'key_results', 'approved', 'status', 'parent_id',
        'edit_by_user', 'completed', 'completed_note','objective_type','allowed_users','timer'
    ];

    protected $with = ['sub_objectives','other_key_results','user'];

    protected $dates = [
        'created_at',
        'updated_at',
        'due_date'
    ];

    protected $casts = [
        'due_date' => 'date:Y-m-d',
    ];


    protected static $logName = 'objectives';

    public function getActivitylogOptions()
    {
        return LogOptions::defaults()
        ->useLogName()
        ->logOnly(['*']);
    }


    /**
     * Get the user that owns the Objective
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sub_objectives()
    {
        return $this->hasMany(Objective::class,'parent_id');
    }

    public function other_key_results()
    {
        return $this->hasMany(KeyResult::class);
    }


    public function trashed_other_key_results()
    {
        return $this->hasMany(KeyResult::class)->withTrashed();
    }



    public function completd_key_results()
    {
        return $this->hasMany(KeyResult::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function chat_messages()
    {
        return $this->hasMany(ChatBox::class,'type_id');
    }


    public function chat_messages_unread()
    {
        return $this->hasMany(ChatBox::class,'type_id')->where('is_read',0)->orderBy('id','asc')->take(3);
    }


}
