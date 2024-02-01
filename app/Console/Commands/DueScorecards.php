<?php

namespace App\Console\Commands;

use App\Models\Scorecard;
use App\Notifications\DueScoreCardNotification;
use Illuminate\Console\Command;
use Notification;

class DueScorecards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scorecard:due-scorecards';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Email When Due Scorecards When They Incomplete';

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

        $scoreCards =  Scorecard::query()
        ->withCount(['histories as incompleted_histories_count' => function ($query) {
            $query->where('completed', 0);
        }])->get();


        foreach ($scoreCards as $key => $eachScoreCard) {
            if($eachScoreCard->incompleted_histories_count){

                if(($eachScoreCard->oldestHistory->due_date) <=  (date("Y-m-d h:i:s", strtotime("+3 day")))){

                sleep(2);

                Notification::send($eachScoreCard->user, new DueScoreCardNotification($eachScoreCard));

                }

            }

        }



    }
}
