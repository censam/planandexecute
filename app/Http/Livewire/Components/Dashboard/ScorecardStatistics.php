<?php

namespace App\Http\Livewire\Components\Dashboard;

use App\Models\Scorecard;
use Livewire\Component;

class ScorecardStatistics extends Component
{
    protected function getListeners()
    {
        return ['ScorecardStatisticsUpdated' => 'render'];
    }


    public function render()
    {
        $current_team = auth()->user()->currentTeam;
        $this->isAdmin = auth()->user()->hasTeamPermission($current_team, 'statistics:read-all');

        $all_scorecards_count = Scorecard::query()
            ->where('team_id', $current_team->id)
            ->when(!$this->isAdmin, function ($query) {
                $query->where('user_id', auth()->user()->id);
            })
            ->count();

        $recurring_scorecards_count = Scorecard::query()
            ->when(!$this->isAdmin, function ($query) {
                $query->where('user_id', auth()->user()->id);
            })
            ->where('team_id', $current_team->id)->where('completed', 2)
            ->count();


        if ($recurring_scorecards_count) {
            $recurring_scorecards_percentage = round(($recurring_scorecards_count / $all_scorecards_count) * 100, 2) . '%';
        } else {
            $recurring_scorecards_percentage = '0' . '%';
        }


        $finished_scorecards_count = Scorecard::query()
            ->when(!$this->isAdmin, function ($query) {
                $query->where('user_id', auth()->user()->id);
            })
            ->where('team_id', $current_team->id)->where('completed', 1)
            ->count();


        if ($finished_scorecards_count) {
            $finished_scorecards_percentage = round(($finished_scorecards_count / $all_scorecards_count) * 100, 2) . '%';
        } else {
            $finished_scorecards_percentage = '0' . '%';
        }


        $not_started_scorecards_count = Scorecard::query()
            ->when(!$this->isAdmin, function ($query) {
                $query->where('user_id', auth()->user()->id);
            })
            ->where('team_id', $current_team->id)->where('completed', 0)
            ->count();


        if ($not_started_scorecards_count) {
            $not_started_scorecards_percentage = round(($not_started_scorecards_count / $all_scorecards_count) * 100, 2) . '%';
        } else {
            $not_started_scorecards_percentage = '0' . '%';
        }


        $recurring_due_scorecards = Scorecard::query()
            ->when(!$this->isAdmin, function ($query) {
                $query->where('user_id', auth()->user()->id);
            })
            ->where('team_id', $current_team->id)->where('completed', 2)
            ->withCount(['histories' => function ($query) {
                $query->where('completed', 0);
            }])
            ->get();
        $recurring_due_scorecards_count = 0;
        foreach ($recurring_due_scorecards as $key => $recurring_due_each_scorecard) {
            if ($recurring_due_each_scorecard->histories_count) {
                $recurring_due_scorecards_count++;
            }
        }


        if ($recurring_due_scorecards_count) {
            $recurring_due_scorecards_percentage = round(($recurring_due_scorecards_count / $all_scorecards_count) * 100, 2) . '%';
        } else {
            $recurring_due_scorecards_percentage = '0' . '%';
        }

        $recurring_completed_scorecard_count = $recurring_scorecards_count - $recurring_due_scorecards_count;


        if ($recurring_completed_scorecard_count) {
            $recurring_completed_scorecard_percentage = round(($recurring_completed_scorecard_count / $all_scorecards_count) * 100, 2) . '%';
        } else {
            $recurring_completed_scorecard_percentage = '0' . '%';
        }

        return view('livewire.components.dashboard.scorecard-statistics', compact(
            'all_scorecards_count',
            'recurring_scorecards_count',
            'recurring_scorecards_percentage',
            'finished_scorecards_count',
            'finished_scorecards_percentage',
            'not_started_scorecards_count',
            'not_started_scorecards_percentage',
            'recurring_due_scorecards_count',
            'recurring_due_scorecards_count',
            'recurring_due_scorecards_percentage',
            'recurring_completed_scorecard_count',
            'recurring_completed_scorecard_percentage'
        ));
    }
}
