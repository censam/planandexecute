<?php

namespace App\Console\Commands;

use App\Models\Objective;
use App\Notifications\DueObjectiveNotification;
use Carbon\Carbon;
use Notification;
use Illuminate\Console\Command;

class DueObjectives extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:due-objectives';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Email When Due Objectives';

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

        $from = date('Y-m-d h:i:s',strtotime("3 days"));

        $to = date('Y-m-d h:i:s',strtotime("$from 3 day"));

        $today_due_objectives_by_user = Objective::whereIn('status',['1','0'])->whereIn('completed',['0','2'])
                                    // ->whereBetween('due_date',[$from, $to])
                                    ->where('due_date', '<=', $from)
                                    ->groupBy('user_id')
                                    ->orderBy('due_date','ASC')
                                    ->get();


        foreach ($today_due_objectives_by_user as $due_objective) {
            Notification::send($due_objective->user, new DueObjectiveNotification($due_objective));
        }


    }
}
