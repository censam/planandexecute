<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Scorecard extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'user_id','team_id','timer','title', 'description', 'kpi_metric','started_at','next_due_date','completed'
    ];

    protected static $logName = 'scorecards';

    public function getActivitylogOptions()
    {
        return LogOptions::defaults()
        ->useLogName()
        ->logOnly(['*']);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function histories()
    {
        return $this->hasMany(ScorecardHistory::class)->orderByDesc('id');
    }


    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function oldestHistory(){
        return $this->hasOne(ScorecardHistory::class)->oldest('due_date')->where('completed',0);
    }


}
