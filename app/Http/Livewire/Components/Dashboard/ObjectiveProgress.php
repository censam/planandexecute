<?php

namespace App\Http\Livewire\Components\Dashboard;

use App\Models\KeyResult;
use App\Models\Objective;
use Livewire\Component;

class ObjectiveProgress extends Component
{
    public $isAdmin;

    protected function getListeners()
    {
        return ['ObjectiveStatisticsUpdated'=>'render'];
    }


    public function render()
    {

        $current_team = auth()->user()->currentTeam;
        $this->isAdmin = auth()->user()->hasTeamPermission($current_team,'statistics:read-all');

        $all_objectives_count = Objective::query()
                                    ->where('team_id',$current_team->id)->whereIn('status',['1','0'])
                                    ->when(!$this->isAdmin, function ($query) {
                                        $query->where('user_id', auth()->user()->id);
                                    })
                                    ->count();

        $completed_objectives_count = Objective::query()
                                        ->when(!$this->isAdmin, function ($query) {
                                            $query->where('user_id', auth()->user()->id);
                                        })
                                        ->where('team_id',$current_team->id)->whereIn('status',['1','0'])->where('completed',1)
                                        ->count();


        if($completed_objectives_count){
            $completed_objectives_percentage = round(($completed_objectives_count/ $all_objectives_count)*100,2).'%';
        }else{
            $completed_objectives_percentage ='0'.'%';
        }


        $missed_objectives_count = Objective::query()
                                        ->when(!$this->isAdmin, function ($query) {
                                            $query->where('user_id', auth()->user()->id);
                                        })
                                        ->where('team_id',$current_team->id)->whereIn('status',['1','0'])->where('completed',3)
                                        ->count();


        if($missed_objectives_count){
            $missed_objectives_percentage = round(($missed_objectives_count/ $all_objectives_count)*100,2).'%';
        }else{
            $missed_objectives_percentage ='0'.'%';
        }



        $reviewing_objectives_count = Objective::query()
                                        ->when(!$this->isAdmin, function ($query) {
                                            $query->where('user_id', auth()->user()->id);
                                        })
                                        ->where('team_id',$current_team->id)->where('status',5)->where('parent_id','!=',0)->count();

        if($reviewing_objectives_count){
            $reviewing_objectives_percentage = round(($reviewing_objectives_count/ $all_objectives_count)*100,2).'%';
        }else{
            $reviewing_objectives_percentage ='0'.'%';
        }

        $not_complete_objectives_count = Objective::query()
                                            ->when(!$this->isAdmin, function ($query) {
                                                $query->where('user_id', auth()->user()->id);
                                            })
                                            ->where('team_id',$current_team->id)->whereIn('status',['1','0'])->whereIn('completed',[0,2])->count();;
        if($not_complete_objectives_count){
            $not_complete_objectives_percentage = round(($not_complete_objectives_count/ $all_objectives_count)*100,2).'%';
        }else{
            $not_complete_objectives_percentage ='0'.'%';
        }


        $in_progress_objectives_count = Objective::query()
                                            ->when(!$this->isAdmin, function ($query) {
                                                $query->where('user_id', auth()->user()->id);
                                            })
                                            ->where('team_id',$current_team->id)->whereIn('status',['1','0'])->where('completed',2)->count();;
        if($in_progress_objectives_count){
            $in_progress_objectives_percentage = round(($in_progress_objectives_count/ $all_objectives_count)*100,2).'%';
        }else{
            $in_progress_objectives_percentage ='0'.'%';
        }


        $not_started_count = Objective::query()
                                ->when(!$this->isAdmin, function ($query) {
                                    $query->where('user_id', auth()->user()->id);
                                })
                                ->where('team_id',$current_team->id)->whereIn('status',['1','0'])->where('completed',0)->count();

        if($not_started_count){
            $not_started_objectives_percentage = round(($not_started_count/ $all_objectives_count)*100,2).'%';
        }else{
            $not_started_objectives_percentage ='0'.'%';
        }

        //team key results start
        $team_key_result_count = KeyResult::query()
                                ->when(!$this->isAdmin, function ($query) {
            $query->where('owner_id', auth()->user()->id)->orWhere('assign_user_id', auth()->user()->id);
        })
        ->where('team_id',$current_team->id)->where('is_team_objective',1)->count();


        $team_key_result_completed_count = KeyResult::query()
                            ->when(!$this->isAdmin, function ($query) {
                                 $query->where('owner_id', auth()->user()->id)->orWhere('assign_user_id', auth()->user()->id);
                            })
        ->where('team_id',$current_team->id)->where('is_team_objective',1)->where('completed',1)->count();


        $team_key_result_not_completed_count = KeyResult::query()
                                ->when(!$this->isAdmin, function ($query) {
            $query->where('owner_id', auth()->user()->id)->orWhere('assign_user_id', auth()->user()->id);
                })
        ->where('team_id',$current_team->id)->where('is_team_objective',1)->where('completed',0)->count();



        if($team_key_result_completed_count){
            $team_key_result_completed_percentage = round(($team_key_result_completed_count/ $team_key_result_count)*100,2).'%';
        }else{
            $team_key_result_completed_percentage ='0'.'%';
        }

        $team_key_result_late_count = KeyResult::query()
                ->when(!$this->isAdmin, function ($query) {
                $query->where('owner_id', auth()->user()->id)->orWhere('assign_user_id', auth()->user()->id);
                })
        ->where('team_id',$current_team->id)->where('is_team_objective',1)->where('completed',0)->where('due_date','<=',  date('Y-m-d h:i:s'))->count();

        //team key results  end



        //individual key results start

        $individual_key_result_count = KeyResult::query()
                                ->when(!$this->isAdmin, function ($query) {
            $query
                ->where('owner_id', auth()->user()->id);
        })
        ->where('team_id',$current_team->id)->where('is_team_objective',0)->count();

        $individual_key_result_completed_count = KeyResult::query()
                                ->when(!$this->isAdmin, function ($query) {
            $query
                ->Where('owner_id', auth()->user()->id);
        })
        ->where('team_id',$current_team->id)->where('is_team_objective',0)->where('completed',1)->count();


        $individual_key_result_not_completed_count = KeyResult::query()
                                ->when(!$this->isAdmin, function ($query) {
            $query
                ->where('owner_id', auth()->user()->id);
                })
        ->where('team_id',$current_team->id)->where('is_team_objective',0)->where('completed',0)->count();




        if($individual_key_result_completed_count){
            $individual_key_result_completed_percentage = round(($individual_key_result_completed_count/ $individual_key_result_count)*100,2).'%';
        }else{
            $individual_key_result_completed_percentage ='0'.'%';
        }



        $individual_key_result_late_count = KeyResult::query()
                                ->when(!$this->isAdmin, function ($query) {
            $query
                ->where('owner_id', auth()->user()->id);
                })
        ->where('team_id',$current_team->id)->where('is_team_objective',0)->where('completed',0)->where('due_date','<=',  date('Y-m-d h:i:s'))->count();


        //individual key results end


        // dd($all_individual_key_result_count);


        return view('livewire.components.dashboard.objective-progress',compact(
            ['all_objectives_count','completed_objectives_count','completed_objectives_percentage','reviewing_objectives_count',
            'missed_objectives_count','missed_objectives_percentage','reviewing_objectives_percentage','not_complete_objectives_count','not_complete_objectives_percentage','in_progress_objectives_count'
            ,'in_progress_objectives_percentage','not_started_count','not_started_objectives_percentage','team_key_result_count','individual_key_result_count'
            ,'team_key_result_completed_count', 'individual_key_result_completed_count','team_key_result_completed_percentage','individual_key_result_completed_percentage'
            ,'individual_key_result_not_completed_count','team_key_result_not_completed_count','team_key_result_late_count','individual_key_result_late_count']
        ));
    }
}
