<?php

namespace App\Console\Commands;

use App\Models\Scorecard;
use App\Models\ScorecardHistory;
use Illuminate\Console\Command;
use NumberFormatter;

class ScorecardRunner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scorecard:runner';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scorcard Execute According to Its Timer';

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
        $from = date('Y-m-d h:i:s',strtotime("-1 day"));



        $today_due_scorecards = Scorecard::where('completed','2')->where('next_due_date', '<=', $from)
                                ->orderBy('next_due_date','ASC')
                                // ->limit(1)
                                ->get();



        foreach ($today_due_scorecards as $due_scorecard) {

            // dd($due_scorecard->histories->count());
            $new_due_date = $this->dueDateTimer($due_scorecard->timer,$due_scorecard->next_due_date);

            Scorecard::where('id', $due_scorecard->id)->update(['next_due_date' => $new_due_date]);


            $counterStr = $this->str_ordinal($due_scorecard->histories->count()+1);

            $scorecardHistoryArr = [
                'note' =>  $counterStr.'-'.ucfirst($due_scorecard->timer).'-'.$due_scorecard->title,
                'scorecard_id' => $due_scorecard->id,
                'user_id' => $due_scorecard->user_id,
                'team_id' => $due_scorecard->team_id,
                'completed' => 0,
                'due_date'=> $new_due_date
            ];

            ScorecardHistory::create($scorecardHistoryArr);
        }
    }


    protected function dueDateTimer($timer,$from)
    {

        if ($timer == 'all') {
            $next_due_date = date('Y-m-d h:i:s', strtotime("10 years"));
        } else if ($timer == 'weekly') {
            $next_due_date = date('Y-m-d h:i:s', strtotime("$from +1 week"));
        } else if ($timer == 'bi-weekly') {
            $next_due_date = date('Y-m-d h:i:s', strtotime("$from +2 week"));
        } else if ($timer == 'monthly') {
            $next_due_date = date('Y-m-d h:i:s', strtotime("$from +31 days"));
        } else if ($timer == 'quarterly') {
            $next_due_date = date('Y-m-d h:i:s', strtotime("$from +91 days"));
        } else if ($timer == 'annual') {
            $next_due_date = date('Y-m-d h:i:s', strtotime("$from +365 days"));
        }

        return $next_due_date;
    }


    protected function str_ordinal($value, $superscript = false)
    {
        $number = abs($value);

        $indicators = ['th','st','nd','rd','th','th','th','th','th','th'];

        $suffix = $superscript ? '<sup>' . $indicators[$number % 10] . '</sup>' : $indicators[$number % 10];
        if ($number % 100 >= 11 && $number % 100 <= 13) {
            $suffix = $superscript ? '<sup>th</sup>' : 'th';
        }

        return number_format($number) . $suffix;
    }
}
