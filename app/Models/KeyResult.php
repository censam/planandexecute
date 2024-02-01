<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class KeyResult extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $with = ['assigned_user','owned_user'];

    protected $fillable = ['objective_id','content','position','completed','assign_user_id','owner_id', 'team_id','is_team_objective','due_date'];

    protected static $logName = 'keyresults';

    public function getActivitylogOptions()
    {
        return LogOptions::defaults()
        ->useLogName()
        ->logOnly(['*']);
    }



    public function objective()
    {
        return $this->belongsTo(Objective::class);
    }


    public function assigned_user()
    {
        return $this->belongsTo(User::class,'assign_user_id');
    }

    public function owned_user()
    {
        return $this->belongsTo(User::class,'owner_id');
    }



}
