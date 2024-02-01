<?php

namespace App\Http\Livewire\Components\Dashboard;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;


use Livewire\Component;

class UserScorecardStatistics extends Component
{
    public $canReadStatistics;

    public function render()
    {
        $current_team = auth()->user()->currentTeam;

        $teamUsers = $current_team->allUsers()->pluck('id');

        $this->canReadStatistics = auth()->user()->hasTeamPermission($current_team,'statistics:read-all');

        $user_statistics = User::withCount([
            'scorecards as finished_count' => function (Builder $query) {
            $query->where('team_id',auth()->user()->currentTeam->id)->where('completed','1');
            },
            'scorecards as recurring_count' => function (Builder $query) {
                $query->where('team_id',auth()->user()->currentTeam->id)->where('completed','2');
            },
            'scorecard_histories as recurring_completed_count' => function (Builder $query) {
                $query->where('team_id',auth()->user()->currentTeam->id)->where('completed','1');
            },
            'scorecard_histories as recurring_due_count' => function (Builder $query) {
                $query->where('team_id',auth()->user()->currentTeam->id)->where('completed','0');
            },
            'scorecards as not_started_count' => function (Builder $query) {
                $query->where('team_id',auth()->user()->currentTeam->id)->where('completed','0');
            },
            'scorecards as all_count' => function (Builder $query) {
                $query->where('team_id',auth()->user()->currentTeam->id);
            }
        ])->whereIn('id',$teamUsers)->get();


        // $asd =  $user_statistics = User::with([
        //     'scorecard_histories as recurring_completed_count' => function (Builder $query) {
        //         $query->where('team_id',auth()->user()->currentTeam->id)->where('completedddd','2');
        //     },
        //     'scorecard_histories as recurring_due_count' => function (Builder $query) {
        //         $query->where('team_id',auth()->user()->currentTeam->id)->where('completed','2');
        //     }])->whereIn('id',$teamUsers)->get();


        //     dd($asd);


        return view('livewire.components.dashboard.user-scorecard-statistics', compact('user_statistics'));
    }
}
