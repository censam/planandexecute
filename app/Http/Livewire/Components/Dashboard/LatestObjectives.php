<?php

namespace App\Http\Livewire\Components\Dashboard;

use App\Models\Objective;
use Livewire\Component;

class LatestObjectives extends Component
{

    public $isAdmin;


    public function render()
    {
        $current_team = auth()->user()->currentTeam;
        $from = date('Y-m-d h:i:s');
        $this->isAdmin = auth()->user()->hasTeamRole(auth()->user()->currentTeam,'objectives:read-all');


        $to = date('Y-m-d h:i:s',strtotime("$from 1 week"));

        $today_due_objectives = Objective::query()
                                ->when(!$this->isAdmin, function ($query) {
                                    $query->where('user_id', auth()->user()->id);
                                })
                                ->where('team_id',$current_team->id)->whereIn('status',['1','0'])->whereIn('completed',['0','2'])->where('due_date','<=', $to)
                                ->orderBy('due_date','ASC')->paginate(5);

        return view('livewire.components.dashboard.latest-objectives',compact('today_due_objectives'));
    }


}
