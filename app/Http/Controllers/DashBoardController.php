<?php

namespace App\Http\Controllers;

use App\Models\KeyResult;
use App\Models\Objective;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class DashBoardController extends Controller
{
    public function index()
    {
        $current_team = auth()->user()->currentTeam;
        $allObjectiveKeyResultsStatistics = $this->objectiveKeyResultsStatistics();
        $userBasedObjectivesStatistics = $this->userBasedObjectivesStatistics();
        $latestTeamObjectives = $this->latestTeamObjectives();
        $teams = $this->teams();
        $isAdmin = auth()->user()->hasTeamPermission($current_team,'objectives:read-all');
        $team_members = $current_team->allUsers();


        $data =  array('objective_key_results_statistics' => $allObjectiveKeyResultsStatistics,
                        'user_based_objectives_statistics' => $userBasedObjectivesStatistics,
                        'current_team_members' => $team_members,
                        'current_team_objectives'=> $latestTeamObjectives,
                        'teams'=> $teams,
                        'is_admin'=> $isAdmin,
                    );


        return response()->json(['data' => $data, 'message' => 'Dashboard data loaded.', 'status' => true]);
    }

    public function allActivities()
    {

        $current_team = auth()->user()->currentTeam;
        $isAdmin = auth()->user()->hasTeamPermission(auth()->user()->currentTeam, 'objectives:read-all');
        $not_approved_objectives = array();

        if($isAdmin){
            $not_approved_objectives = Objective::where('team_id', $current_team->id)->where('status', 5)->where('parent_id', '!=', 0)->get();
        }


        $objective_notifications = $this->latestActivities('objectives', 6);
        $scorecards_notifications = $this->latestActivities('scorecards', 6);
        $keyresults_notifications = $this->latestActivities('keyresults', 6);
        $data = compact('objective_notifications','scorecards_notifications','keyresults_notifications','not_approved_objectives');
        return response()->json(['data' => $data, 'message' => 'Latest Activities Loaded.', 'status' => true]);

    }

    public function latestActivities($type, $limit = 5)
    {
        $today = date('Y-m-d h:i:s');
        $to = date('Y-m-d h:i:s', strtotime("$today +1 day"));
        $from = date('Y-m-d h:i:s', strtotime("$to -14 days"));
        $user_id = auth()->user()->id;
        $current_team = auth()->user()->currentTeam;
        $isAdmin = auth()->user()->hasTeamPermission(auth()->user()->currentTeam, 'objectives:read-all');


        return  Activity::query()
        ->with('causer','subject')
            ->where('log_name', $type)
            ->whereHas('subject', function (Builder $query) use ($current_team) {
                $query->where('team_id', $current_team->id);
            })
            ->when((!$isAdmin), function ($query) use ($type,$user_id) {

                $query->where('causer_id', $user_id);
                if ($type == 'objectives') {
                    $query->whereHasMorph('subject', [Objective::class], function (Builder $query) use ($user_id) {
                        $query->where('user_id', $user_id)->whereIn('status', [1]);
                    });
                }
            })

            ->whereBetween('created_at', [$from, $to])
            ->orderBy('updated_at', 'desc')->limit($limit)->get();
    }


    public function teams()
    {
        $teams_as_super_admin = auth()->user()->ownedTeams;
        $teams_as_others = auth()->user()->teams;
        return compact('teams_as_super_admin','teams_as_others');
    }


    public function latestTeamObjectives()
    {
        $current_team = auth()->user()->currentTeam;
        $isAdmin = auth()->user()->hasTeamPermission($current_team,'objectives:read-all');

        $latest_team_objectives = Objective::query()
                                    ->where('team_id',$current_team->id)
                                    ->when(!$isAdmin, function ($query) {
                                        $query->where('user_id', auth()->user()->id);
                                    })
                                    ->orderBy('created_at','DESC')->whereIn('status',['1','0'])->limit(5)->get();



        $team_objectives_count = Objective::query()
                                    ->where('team_id',$current_team->id)->whereIn('status',['1','0'])
                                    ->when(!$isAdmin, function ($query) {
                                        $query->where('user_id', auth()->user()->id);
                                    })
                                    ->count();

         return compact('team_objectives_count','latest_team_objectives');
    }

    public function userBasedObjectivesStatistics()
    {
        $teamUsers = auth()->user()->currentTeam->allUsers()->pluck('id');

        $current_team = auth()->user()->currentTeam;
        $canReadStatistics = auth()->user()->hasTeamPermission($current_team,'statistics:read-all');


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

            return $user_statistics;
    }

    public function objectiveKeyResultsStatistics()
    {
        $current_team = auth()->user()->currentTeam;
        $isAdmin = auth()->user()->hasTeamPermission($current_team, 'statistics:read-all');

        $all_objectives_count = Objective::query()
            ->where('team_id', $current_team->id)->whereIn('status', ['1', '0'])
            ->when(!$isAdmin, function ($query) {
                $query->where('user_id', auth()->user()->id);
            })
            ->count();

        $completed_objectives_count = Objective::query()
            ->when(!$isAdmin, function ($query) {
                $query->where('user_id', auth()->user()->id);
            })
            ->where('team_id', $current_team->id)->whereIn('status', ['1', '0'])->where('completed', 1)
            ->count();


        if ($completed_objectives_count) {
            $completed_objectives_percentage = round(($completed_objectives_count / $all_objectives_count) * 100, 2) . '%';
        } else {
            $completed_objectives_percentage = '0' . '%';
        }


        $missed_objectives_count = Objective::query()
            ->when(!$isAdmin, function ($query) {
                $query->where('user_id', auth()->user()->id);
            })
            ->where('team_id', $current_team->id)->whereIn('status', ['1', '0'])->where('completed', 3)
            ->count();


        if ($missed_objectives_count) {
            $missed_objectives_percentage = round(($missed_objectives_count / $all_objectives_count) * 100, 2) . '%';
        } else {
            $missed_objectives_percentage = '0' . '%';
        }



        $reviewing_objectives_count = Objective::query()
            ->when(!$isAdmin, function ($query) {
                $query->where('user_id', auth()->user()->id);
            })
            ->where('team_id', $current_team->id)->where('status', 5)->where('parent_id', '!=', 0)->count();

        if ($reviewing_objectives_count) {
            $reviewing_objectives_percentage = round(($reviewing_objectives_count / $all_objectives_count) * 100, 2) . '%';
        } else {
            $reviewing_objectives_percentage = '0' . '%';
        }

        $not_complete_objectives_count = Objective::query()
            ->when(!$isAdmin, function ($query) {
                $query->where('user_id', auth()->user()->id);
            })
            ->where('team_id', $current_team->id)->whereIn('status', ['1', '0'])->whereIn('completed', [0, 2])->count();;
        if ($not_complete_objectives_count) {
            $not_complete_objectives_percentage = round(($not_complete_objectives_count / $all_objectives_count) * 100, 2) . '%';
        } else {
            $not_complete_objectives_percentage = '0' . '%';
        }


        $in_progress_objectives_count = Objective::query()
            ->when(!$isAdmin, function ($query) {
                $query->where('user_id', auth()->user()->id);
            })
            ->where('team_id', $current_team->id)->whereIn('status', ['1', '0'])->where('completed', 2)->count();;
        if ($in_progress_objectives_count) {
            $in_progress_objectives_percentage = round(($in_progress_objectives_count / $all_objectives_count) * 100, 2) . '%';
        } else {
            $in_progress_objectives_percentage = '0' . '%';
        }


        $not_started_count = Objective::query()
            ->when(!$isAdmin, function ($query) {
                $query->where('user_id', auth()->user()->id);
            })
            ->where('team_id', $current_team->id)->whereIn('status', ['1', '0'])->where('completed', 0)->count();

        if ($not_started_count) {
            $not_started_objectives_percentage = round(($not_started_count / $all_objectives_count) * 100, 2) . '%';
        } else {
            $not_started_objectives_percentage = '0' . '%';
        }

        //team key results start
        $team_key_result_count = KeyResult::query()
            ->when(!$isAdmin, function ($query) {
                $query->where('owner_id', auth()->user()->id)->orWhere('assign_user_id', auth()->user()->id);
            })
            ->where('team_id', $current_team->id)->where('is_team_objective', 1)->count();


        $team_key_result_completed_count = KeyResult::query()
            ->when(!$isAdmin, function ($query) {
                $query->where('owner_id', auth()->user()->id)->orWhere('assign_user_id', auth()->user()->id);
            })
            ->where('team_id', $current_team->id)->where('is_team_objective', 1)->where('completed', 1)->count();


        $team_key_result_not_completed_count = KeyResult::query()
            ->when(!$isAdmin, function ($query) {
                $query->where('owner_id', auth()->user()->id)->orWhere('assign_user_id', auth()->user()->id);
            })
            ->where('team_id', $current_team->id)->where('is_team_objective', 1)->where('completed', 0)->count();



        if ($team_key_result_completed_count) {
            $team_key_result_completed_percentage = round(($team_key_result_completed_count / $team_key_result_count) * 100, 2) . '%';
        } else {
            $team_key_result_completed_percentage = '0' . '%';
        }

        $team_key_result_late_count = KeyResult::query()
            ->when(!$isAdmin, function ($query) {
                $query->where('owner_id', auth()->user()->id)->orWhere('assign_user_id', auth()->user()->id);
            })
            ->where('team_id', $current_team->id)->where('is_team_objective', 1)->where('completed', 0)->where('due_date', '<=',  date('Y-m-d h:i:s'))->count();

        //team key results  end



        //individual key results start

        $individual_key_result_count = KeyResult::query()
            ->when(!$isAdmin, function ($query) {
                $query
                    ->where('owner_id', auth()->user()->id);
            })
            ->where('team_id', $current_team->id)->where('is_team_objective', 0)->count();

        $individual_key_result_completed_count = KeyResult::query()
            ->when(!$isAdmin, function ($query) {
                $query
                    ->Where('owner_id', auth()->user()->id);
            })
            ->where('team_id', $current_team->id)->where('is_team_objective', 0)->where('completed', 1)->count();


        $individual_key_result_not_completed_count = KeyResult::query()
            ->when(!$isAdmin, function ($query) {
                $query
                    ->where('owner_id', auth()->user()->id);
            })
            ->where('team_id', $current_team->id)->where('is_team_objective', 0)->where('completed', 0)->count();




        if ($individual_key_result_completed_count) {
            $individual_key_result_completed_percentage = round(($individual_key_result_completed_count / $individual_key_result_count) * 100, 2) . '%';
        } else {
            $individual_key_result_completed_percentage = '0' . '%';
        }



        $individual_key_result_late_count = KeyResult::query()
            ->when(!$isAdmin, function ($query) {
                $query
                    ->where('owner_id', auth()->user()->id);
            })
            ->where('team_id', $current_team->id)->where('is_team_objective', 0)->where('completed', 0)->where('due_date', '<=',  date('Y-m-d h:i:s'))->count();


        return compact(
            [
                'all_objectives_count', 'completed_objectives_count', 'completed_objectives_percentage', 'reviewing_objectives_count',
                'missed_objectives_count', 'missed_objectives_percentage', 'reviewing_objectives_percentage', 'not_complete_objectives_count', 'not_complete_objectives_percentage', 'in_progress_objectives_count', 'in_progress_objectives_percentage', 'not_started_count', 'not_started_objectives_percentage', 'team_key_result_count', 'individual_key_result_count', 'team_key_result_completed_count', 'individual_key_result_completed_count', 'team_key_result_completed_percentage', 'individual_key_result_completed_percentage', 'individual_key_result_not_completed_count', 'team_key_result_not_completed_count', 'team_key_result_late_count', 'individual_key_result_late_count'
            ]
        );
    }
}
