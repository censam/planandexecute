<?php

namespace App\Http\Livewire\Components\Dashboard;

use App\Models\Objective;
use Livewire\Component;

class StaticsCards extends Component
{

    public $isAdmin;

    public $countTeams;

    public function render()
    {
        $current_team = auth()->user()->currentTeam;

        $team_members = $current_team->allUsers();

        $this->isAdmin = auth()->user()->hasTeamPermission($current_team,'objectives:read-all');

        $this->countTeams = auth()->user()->teams->count()+auth()->user()->ownedTeams->count();



        $latest_team_objectives = Objective::query()
                                    ->where('team_id',$current_team->id)
                                    ->when(!$this->isAdmin, function ($query) {
                                        $query->where('user_id', auth()->user()->id);
                                    })
                                    ->orderBy('created_at','DESC')->whereIn('status',['1','0'])->limit(5)->get();



        $team_objectives_count = Objective::query()
                                    ->where('team_id',$current_team->id)->whereIn('status',['1','0'])
                                    ->when(!$this->isAdmin, function ($query) {
                                        $query->where('user_id', auth()->user()->id);
                                    })
                                    ->count();




        return view('livewire.components.dashboard.statics-cards',compact(['latest_team_objectives','team_objectives_count','team_members']));
    }




}
