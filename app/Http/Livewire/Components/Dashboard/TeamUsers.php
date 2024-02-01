<?php

namespace App\Http\Livewire\Components\Dashboard;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;
use Livewire\Component;

class TeamUsers extends Component
{


    public $canReadStatistics;

    public function render()
    {
        $teamUsers = auth()->user()->currentTeam->allUsers()->pluck('id');

        $current_team = auth()->user()->currentTeam;
        $this->canReadStatistics = auth()->user()->hasTeamPermission($current_team,'statistics:read-all');


            $user_statistics = User::withCount([
                'objectives as completed_count' => function (Builder $query) {
                $query->where('team_id',auth()->user()->currentTeam->id)->where('completed','1')->whereIn('status',['1','0']);
                },
                'objectives as missed_count' => function (Builder $query) {
                    $query->where('team_id',auth()->user()->currentTeam->id)->where('completed','3')->whereIn('status',['1','0']);
                },
                'objectives as not_completed_count' => function (Builder $query) {
                    $query->where('team_id',auth()->user()->currentTeam->id)->whereIn('completed',['0','2'])->whereIn('status',['1','0']);
                },
                'objectives as in_reviewing_count' => function (Builder $query) {
                    $query->where('team_id',auth()->user()->currentTeam->id)->where('parent_id','!=',0)->where('status','5');
                },
                'objectives as in_progress_count' => function (Builder $query) {
                    $query->where('team_id',auth()->user()->currentTeam->id)->where('completed','2')->whereIn('status',['1','0']);
                },
                'objectives as not_started_count' => function (Builder $query) {
                    $query->where('team_id',auth()->user()->currentTeam->id)->where('completed','0')->whereIn('status',['1','0']);
                },
                'objectives as all_count' => function (Builder $query) {
                    $query->where('team_id',auth()->user()->currentTeam->id)->whereIn('status',['1','0']);
                }
            ])->whereIn('id',$teamUsers)->get();


        return view('livewire.components.dashboard.team-users', compact('user_statistics'));
    }
}
