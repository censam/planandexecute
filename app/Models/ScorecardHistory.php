<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ScorecardHistory extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = ['scorecard_id', 'user_id', 'team_id', 'due_date' ,'note','completed','completed_at'];

    protected $dates = [
        'created_at',
        'updated_at',
        'due_date',
        'completed_at',
        // your other new column
    ];

    protected static $logName = 'scorecards_history';

    public function getActivitylogOptions()
    {
        return LogOptions::defaults()
        ->useLogName()
        ->logOnly(['*']);
    }

    public function scoreCard()
    {
        return $this->belongsTo(ScoreCard::class);
    }

    public function assigned_user()
    {
        return $this->belongsTo(User::class);
    }
}
