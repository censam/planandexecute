<?php

namespace App\Http\Livewire;

use App\Models\ChatBox;
use App\Models\ChatUser;
use App\Models\KeyResult;
use App\Models\Objective;
use Carbon\Carbon;
use DateTime;
// use Illuminate\Routing\Route;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Route;
use Spatie\Activitylog\Models\Activity;

/*
When Team Member 'EDIT' an objective, newly  creates edited objective with new record  and link with parent_id.
and that sub-objective convert 'STATUS' 1 to 5 AND 'APPROVED' to 0 and add PARENT_ID

When admin 'APPROVE' this objective , Edited-Objective 'STATUS' change 5 to 1 AND 'APPROVE' change to 0 to 1
AND parent objective 'STATUS' 1 to 7
*/


class Objectives extends Component
{
    use WithPagination;

    // protected $listeners = ['update_not_approve_count'=>'render','selectedUser', 'taskResultAdded'=>'render'];
    protected $listeners = ['clearsearch','update_not_approve_count' => 'render', 'selectedUser', 'taskResultAdded' => 'render','searchTrigger','showTrigger'=>'show','showTriggerKeyResult','ObjectiveChangedkeyresultPopup','reviewTrigger'=>'review'];
    // protected $listeners = [,'replaceEditedObjective'=>'removeSubObjectives','selectedUser'];

    public  $name, $objective_id, $description, $due_date, $key_results, $completed_note, $completed_at, $current_objective, $user_id, $completed, $objective_type, $allowed_users, $timer;
    public $confirming;
    public $isOpen, $isEdit, $isCreate;
    public $openType;
    public $sorting;
    public $sortingTimer;
    public $sortingStatus;
    public $pagesize;
    public $isAdmin;
    public $multiple_message, $objective_message;
    public $loaded_user_id;
    public $loaded_route;
    public $loaded_objective_id;
    public $search;
    public $current_team;
    public $allCount;
    public $isObjRestoreOpen;
    public $restoreConfirmedObjective;
    public $hardDeleteConfirmedObjective;
    public $isObjHardDeleteOpen;
    public $isKeyResultsProgomatic;
    public $keyResultsProgomaticData = array();




    public function mount()
    {

        $this->isOpen = 0;
        $this->allCount = 0;
        $this->openType = 'show';
        $this->sortingTimer = 'all';
        $this->sortingStatus= 'all';
        $this->pagesize = 10;
        $this->objective_type = 1;
        $this->timer = '';
        $this->allowed_users = '';
        $this->isEdit = false;
        $this->isCreate  = false;
        $this->loaded_objective_id = '';
        $this->isObjRestoreOpen = false;
        $this->isObjHardDeleteOpen = false;
        $this->restoreConfirmedObjective = 0;
        $this->hardDeleteConfirmedObjective = 0;
        $this->isKeyResultsProgomatic = false;
        $this->keyResultsProgomaticData = [];





        $this->loaded_route = Route::currentRouteName();

        if($this->loaded_route == 'due_objectives'){
            $this->sorting = 'all';
            $this->sortingStatus = '0,2,3';
        }else{
            $this->sorting = 'all';
        }


        $this->loaded_user_id = auth()->user()->id;

        if (isset(Route::current()->parameters['id']) && ( $this->loaded_route == 'user.show')) {

            if (isset(Route::current()->parameters['id']) && ( $this->loaded_route == 'user.show')) {
                $this->loaded_user_id = request()->route()->parameters['id'];
            }
        }


        if (isset(Route::current()->parameters['id']) && ( $this->loaded_route == 'objectives.show')) {
            $this->loaded_objective_id = request()->route()->parameters['id'];

        }


     }

    /**
     * @param mixed $id -> notification id
     *
     * @return [type]
     * this is trigger via notificationheader componenet passing
     */
    public function showTriggerKeyResult($id)
    {
        $activity = Activity::findOrFail($id);
        $this->show($activity->subject->objective_id);
        $this->emit('highlight',$activity->subject->id);
        // dd($activity->subject->id);
    }



    public function ObjectiveChangedkeyresultPopup($data)
    {

        $this->isKeyResultsProgomatic = true;
        $this->keyResultsProgomaticData = $data;


    }


    public function ChangeObjectiveStatus($id,$completed)
    {
        $objective = Objective::findOrFail($id);
        $objective->completed = $completed;
        $objective->save();
        $this->edit($id);
        $this->isKeyResultsProgomatic = false;
    }


    public function clearsearch()
    {
        $this->search = '';
    }

    public function searchTrigger($id)
    {
        $objective = Objective::findOrFail($id);
        $this->search = $objective->name;
        $this->emit('openChatByNotification',$id);
    }


    public function openChat($id)
    {
        $this->searchTrigger($id);
    }


    public function confirmObjectiveRestore($id)
    {
        $this->isObjRestoreOpen = true;
        $this->restoreConfirmedObjective = $id;
    }



    public function confirmObjectiveHardDelete($id)
    {
        $this->isObjHardDeleteOpen = true;
        $this->hardDeleteConfirmedObjective = $id;
    }



    public function render()
    {

        $this->current_team = $current_team_id = $current_team =  auth()->user()->currentTeam;

        // $team_members = $current_team->allUsers()->pluck('name','id');

        $team_members = $current_team->allUsers();

        if ($this->current_objective) {
            $this->isEdit = true;
            $this->isCreate  = false;
        } else {
            $this->isEdit = false;
            $this->isCreate  = true;
        }

        $from = date('Y-m-d h:i:s');

        $this->isAdmin = auth()->user()->hasTeamPermission(auth()->user()->currentTeam, 'objectives:read-all');

        $not_approved_count = 0;

        // dd($not_approved_count);
        if ($this->sorting == 'all') {
            // $to = date('Y-m-d h:i:s', strtotime("$from 10 years"));
            $to = 'all';
        } else if ($this->sorting == 'weekly') {
            $to = date('Y-m-d h:i:s', strtotime("$from +1 week"));
        } else if ($this->sorting == 'monthly') {
            $from = date('Y-m-01 h:i:s');
            $to = date('Y-m-t h:i:s');
        } else if ($this->sorting == 'quarterly') {
            $quarter = $this->getQuarter(new DateTime());
            // dd();
            $from = date('Y-m-d h:i:s', strtotime($quarter['start']));
            $to = date('Y-m-d h:i:s', strtotime($quarter['end']));
        } else if ($this->sorting == 'annual') {
            $from = date('Y-01-01 h:i:s');
            $to = date('Y-12-31 h:i:s', strtotime("$from 365 days"));
        }


        if($this->loaded_route == 'objectives.show'){
            $objectives = Objective::query()
            ->when((!$this->isAdmin), function ($query) {
                $query->whereIn('completed', [$this->sortingStatus]);
            })
            ->when((strlen($this->search)>1), function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%')->orWhere('description', 'like', '%'.$this->search.'%')->where('team_id', $this->current_team->id);
            })
            ->where('id' ,$this->loaded_objective_id)
            ->orWhere('allowed_users', 'like', '%,' . $this->loaded_user_id . '%')
                ->withCount(['other_key_results as completed_key_result_count' => function ($query) {
                    $query->where('completed', 1);
            }])
            ->where('id' ,$this->loaded_objective_id)
                ->paginate();





        }elseif($this->loaded_route == 'archived_objectives') {

            $objectives = Objective::query()
            ->when((!$this->isAdmin), function ($query) {
                $query->where('user_id', [$this->loaded_user_id]);
            })
            ->onlyTrashed()
            ->where('team_id', $current_team->id)
            ->orderBy('id', 'DESC')
            ->withCount(['other_key_results as completed_key_result_count' => function ($query) {
                $query->where('completed', 1);
            }])
            ->paginate($this->pagesize);



        }elseif(($this->isAdmin) && ($this->loaded_route != 'user.show')) {

            $objectives = Objective::query()
                ->when(($this->sortingStatus != 'all'), function ($query) {
                    $query->whereIn('completed', [$this->sortingStatus]);
                })
                ->where('team_id', $current_team_id->id)
                ->whereIn('status', ['1', '0'])
                ->when((strlen($this->search)>1), function ($query) {
                    $query->where('name', 'like', '%'.$this->search.'%')->orWhere('description', 'like', '%'.$this->search.'%')->where('team_id', $this->current_team->id);
                })
                ->when(($to), function ($query) use ($from,$to) {
                    if($to=='all'){
                        $to = date('Y-m-d h:i:s', strtotime("$from 10 years"));
                        $query->where('due_date', '<=', $to);
                    }else{
                        $query->whereBetween('due_date',[$from, $to]);
                    }

                })
                ->orderBy('id', 'DESC')
                ->withCount(['other_key_results as completed_key_result_count' => function ($query) {
                    $query->where('completed', 1);
                }])
                ->paginate($this->pagesize);

            $count_label = '<span class="px-3 py-2 font-semibold text-white bg-red-700 rounded-full">' . $not_approved_count . '</span>';

            $this->multiple_message = [
                'color' => 'green',
                'count' => $not_approved_count,
                'message' => 'There are ' . $count_label . ' Objective' . (($not_approved_count > 1) ? 's' : '') . ' Pending For Approve'
            ];

        } else {
            //this is tememembers when in dashboard and objectives page
            $objectives = Objective::query()
                ->when(($this->sortingStatus != 'all'), function ($query) {
                    $query->whereIn('completed', [$this->sortingStatus]);
                })
                ->where('team_id', $current_team_id->id)
                ->whereIn('status', ['1', '0'])
                ->when((strlen($this->search)>1), function ($query) {
                    $query->where('user_id',$this->loaded_user_id)
                        ->where('name','like', '%'.$this->search.'%')->orWhere('description', 'like', '%'.$this->search.'%')->where('team_id', $this->current_team->id);
                })
                ->when(($to), function ($query) use ($from,$to) {
                    if($to=='all'){
                        $to = date('Y-m-d h:i:s', strtotime("$from 10 years"));
                        $query->where('due_date', '<=', $to);
                    }else{
                        $query->whereBetween('due_date',[$from, $to]);
                    }

                })
                ->where('user_id', $this->loaded_user_id)
                ->where('team_id', $this->current_team->id)->orderBy('id', 'DESC')
                ->orWhere('allowed_users', 'like', '%,' . $this->loaded_user_id . '%')->where('team_id', $current_team_id->id)
                ->when((!strlen($this->search)>0), function ($query) {
                    // $query->orWhere('allowed_users', 'like', '%,' . $this->loaded_user_id . '%');
                })
                ->withCount(['other_key_results as completed_key_result_count' => function ($query) {
                    $query->where('completed', 1);
                }])
                ->paginate($this->pagesize);
        }



        $options = array('1' => 'Completed', '0' => 'Not Started', '2' => 'In-Progress','3' => 'Missed');

        $sortingStatusArr = array('1' => 'Completed', '0' => 'Not Started', '2' => 'In-Progress','3' => 'Missed');

        $timeSortOptions = array('' => 'Select Time', 'weekly' => 'Weekly', 'monthly' => 'Monthly', 'quarterly' => 'Quarterly', 'annual' => 'Annual');

        // $this->emit('ObjectiveStatisticsUpdated');

        if($this->loaded_route=='archived_objectives'){
            return view('livewire.objectives.archieved_objectives', [
                'objectives' => $objectives,
                'options' => $options,
                'team_members' => $team_members,
                'sortingStatusArr' => $sortingStatusArr,
                'time_sort_options' => $timeSortOptions
            ]);
        }

        return view('livewire.objectives.objectives', [
            'objectives' => $objectives,
            'options' => $options,
            'team_members' => $team_members,
            'sortingStatusArr' => $sortingStatusArr,
            'time_sort_options' => $timeSortOptions
        ]);
    }



    public function create()
    {
        $this->resetInputFields();
        $this->openModal('edit');
        $this->user_id = auth()->user()->id;
    }


    public function openModal($type = 'show')
    {
        $this->resetValidation();
        $this->isOpen = true;
        $this->openType = $type;
    }


    public function closeModal()
    {
        $this->isOpen = false;
    }


    public function resetInputFields()
    {
        $this->objective_id = '';
        $this->name = '';
        $this->description = '';
        $this->due_date = '';
        $this->current_objective = '';
        $this->completed_note = '';
        $this->objective_type = '';
        $this->allowed_users = '';
        $this->timer = '';
    }


    public function getQuarter(\DateTime $DateTime) {
            $y = $DateTime->format('Y');
            $m = $DateTime->format('m');
            switch($m) {
                case $m >= 1 && $m <= 3:
                    $start = '01/01/'.$y;
                    $end = (new DateTime('03/1/'.$y))->modify('Last day of this month')->format('m/d/Y');
                    $title = 'Q1 '.$y;
                    break;
                case $m >= 4 && $m <= 6:
                    $start = '04/01/'.$y;
                    $end = (new DateTime('06/1/'.$y))->modify('Last day of this month')->format('m/d/Y');
                    $title = 'Q2 '.$y;
                    break;
                case $m >= 7 && $m <= 9:
                    $start = '07/01/'.$y;
                    $end = (new DateTime('09/1/'.$y))->modify('Last day of this month')->format('m/d/Y');
                    $title = 'Q3 '.$y;
                    break;
                case $m >= 10 && $m <= 12:
                    $start = '10/01/'.$y;
                    $end = (new DateTime('12/1/'.$y))->modify('Last day of this month')->format('m/d/Y');
                    $title = 'Q4 '.$y;
                    break;
            }
            return array(
                    'start' => $start,
                    'end' => $end,
                    'title'=>$title,
                    'start_nix' => strtotime($start),
                    'end_nix' => strtotime($end)
            );
        }


    public function store()
    {

        request()->input('user_id', $this->user_id);

        // dd(auth()->user()->hasTeamRole(auth()->user()->currentTeam,'admin'));
        $messages = [
            'name.required' => 'Please fill objective name here.',
            'description.required' => 'Please fill objective description here.',
            'due_date.required' => 'Please fill objective due date here.',
            'completed_note.required_if' => 'Please fill complete note here.',
            'user_id.required' => 'Please assign a member to the objective.',
        ];

        $rules = [
            'name' => 'required',
            'description' => 'min:10',
            // 'completed_note' =>  'required_if:completed,1',
            'user_id' => 'required',
        ];

        if ($this->objective_id) {
            $rules['due_date'] ='required|date';
        }else{
            $rules['due_date'] ='required|date|after:yesterday';
        }


        $this->validate($rules, $messages);
        //check action update_or_create


        //check has permission to update
        if (auth()->user()->hasTeamPermission(auth()->user()->currentTeam, 'objective:update')) {

            if ($this->objective_id) {
                //update
                $objective = Objective::find($this->objective_id);
                $team_id = $objective->team_id;
                $user_id = $objective->user_id;
            } else {
                //create
                $team_id = auth()->user()->currentTeam->id;
                $user_id = auth()->user()->id;
            }

            if (is_array($this->allowed_users) && ($this->objective_type == '1')) {
                // array_push($this->allowed_users,auth()->user()->id);

                // dd($this->allowed_users);
                $allowed_user_str =  implode(',', $this->allowed_users);
                $allowed_user_str =  auth()->user()->id . ',' . $allowed_user_str;
            } else {
                $allowed_user_str =  $this->allowed_users;
            }

            $objectiveArr = [
                'name' => $this->name,
                'user_id' => $this->user_id,
                'team_id' => $team_id,
                'description' => $this->description,
                'objective_type' => $this->objective_type,
                'due_date' => $this->due_date,
                'completed_note' => $this->completed_note,
                'edit_by_user' => auth()->user()->id,
                'allowed_users' => $allowed_user_str,
                'timer' => $this->timer,


            ];

            //Added to avoid (malfunctional edit) if another team member updateded it his side
            if (!$this->objective_id) {
                $objectiveArr['approved'] = 1;
                $objectiveArr['status'] = 1;
                $objectiveArr['parent_id'] = 0;
            }


            //if yes update directly
            if ($this->objective_id) {
                Objective::updateOrCreate(['id' => $this->objective_id], $objectiveArr);
            } else {
                $newObjectiveData = Objective::updateOrCreate(['id' => ''], $objectiveArr);
            }
        } else {
            //if not permisssions to update , create a duplicate objective and link to parent one



            //check action update_or_create
            if ($this->objective_id) {
                //update with permissions
                $objective = Objective::find($this->objective_id);
                $status = 5;
                $approved = 0;
                $parent_id =  $objective->id;
                $team_id = $objective->team_id;
                $user_id = auth()->user()->id;
            } else {
                //create without permissions
                $status = 1;
                $approved = 1;
                $parent_id =  0;
                $team_id = auth()->user()->currentTeam->id;
                $user_id = auth()->user()->id;
            }

            $objectiveArr = [
                'name' => $this->name,
                'user_id' => $user_id,
                'team_id' => $team_id,
                'description' => $this->description,
                'due_date' => date("Y-m-d H:i:s", strtotime($this->due_date)),
                'completed_note' => $this->completed_note,
                'edit_by_user' => auth()->user()->id,
                'approved' => $approved,
                'status' => $status,
                'timer' => $this->timer,
                'parent_id' => $parent_id,
            ];




            if (isset($objective)) {

                if (($objective->name != $objectiveArr['name']) || ($objective->description != $objectiveArr['description']) || ($objective->due_date != $objectiveArr['due_date'])) {
                    //create duplicate object with update changes
                    $data = array('old_data' => $objective, 'new_data' => $objectiveArr);
                    // dd($data);
                    Objective::updateOrCreate(['id' => ''], $objectiveArr);

                    if (isset($objective->id)) {
                        Objective::updateOrCreate(['id' => $objective->id], ['approved' => 0]);
                    }
                }
            } else {
                //fresh objective create wby team member
                $newObjectiveData = Objective::updateOrCreate(['id' => ''], $objectiveArr);
            }
        }


        // activity()->log('Look mum, I logged something');
        // activity()->performedOn($objective)->withProperties(['read' => '0'])->log('edited');


        // session()->flash('message',$this->objective_id?'Objective Updated Successfully.':'Objective Updated Successfully.');

        $this->objective_message = [
            'color' => 'green',
            'count' => 1,
            'message' => $this->objective_id ? 'Objective Updated Successfully.' : 'Objective Updated Successfully.'
        ];


        if (isset($newObjectiveData)) {
            $this->action($newObjectiveData->id);
        } else {
            $this->closeModal();
            $this->resetInputFields();
        }
    }


    public function keepOriginal($id)
    {
        $objective = Objective::findOrFail($id);
        $objective->approved = 1;
        $objective->save();

        Objective::where('parent_id', $objective->id)->delete();

        $this->closeModal();
        session()->flash('message', 'Removed Edited Objective Successfully,Kept Original one No.' . $id);
    }


    public function keepEdited($id)
    {
        $objective = Objective::findOrFail($id);
        // dd($objective->parent_id);
        Objective::where('id', $id)->update(['status' => 1, 'approved' => 1]);
        Objective::where('id', $objective->parent_id)->update(['status' => 7, 'approved' => 0]);
        KeyResult::where('objective_id', $objective->parent_id)->update(['objective_id' => $objective->id]);
        $this->closeModal();


        session()->flash('message', 'Edited Objective Replaced Successfully');
        // $parent_objective = Objective::find('id',$objective->parent_id);
        // dd($parent_objective);
        // $parent_objective->status = 0;
        // $parent_objective->approved = 0;
        // $parent_objective->save();

        // unset($this->current_objective->sub_objectives[0]);

    }




    public function edit($id)
    {
        $this->action($id);
        $this->openModal('edit');
    }


    public function action($id)
    {
        $objective = Objective::query()->where('id', $id)
                        ->withCount(['other_key_results as completed_key_result_count' => function ($query) {
                        $query->where('completed', 1);
                    }])->withTrashed()->first();

        $this->objective_id = $id;
        $this->name = $objective->name;
        $this->user_id = $objective->user_id;
        $this->description = $objective->description;
        $this->objective_type = $objective->objective_type;
        $this->timer = $objective->timer;
        $this->due_date =  Carbon::parse($objective->due_date)->format('Y-m-d');
        $this->completed_note = $objective->completed_note;
        $this->completed = $objective->completed;
        $this->current_objective = $objective;
        $this->allowed_users = $objective->allowed_users;
        $this->allCount = $objective->chat_messages->count();

        //    dd($this->due_date );
    }


    public function show($id)
    {
        $this->action($id);
        $this->openModal('show');
    }

    public function review($id)
    {
        $this->action($id);
        $this->openModal('review');
    }




    public function confirmDelete($id)
    {
        $this->confirming = $id;
    }

    public function selectedUser($user_id)
    {
        $this->user_id = $user_id;
    }


    public function restoreObjective($id)
    {
        Objective::withTrashed()
        ->where('id', $id)
        ->restore();

        $this->isObjRestoreOpen = false;
    }


    public function hardDeleteObjective($id)
    {
        $objective = Objective::withTrashed()->find($id);
        // dd($objective);
        $objective->forceDelete();
        Objective::where('parent_id', $id)->where('status', 5)->forceDelete();
        KeyResult::where('objective_id', $id)->forceDelete();
        ChatUser::where('type','objectives')->where('type_id',$id)->forceDelete();
        ChatBox::where('type','objectives')->where('type_id',$id)->forceDelete();

        $this->objective_message = [
            'color' => 'red',
            'count' => 1,
            'message' => 'Objective Deleted Successfully'
        ];

        $this->isObjHardDeleteOpen = false;
    }




    public function delete($id)
    {
        Objective::find($id)->delete();
        Objective::where('parent_id', $id)->where('status', 5)->delete();
        // KeyResult::where('objective_id', $id)->delete();
        $this->objective_message = [
            'color' => 'red',
            'count' => 1,
            'message' => 'Objective Deleted Successfully'
        ];
    }


    //this event is trigger from togglebutton live wire when click objectives approve
    public function removeSubObjectives(Objective $objective)
    {
        Log::info($objective);
        Log::info("message event emit");
        dd($objective);
    }
}
