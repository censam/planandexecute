<?php

namespace App\Http\Controllers;

use App\Http\Resources\Objective as ObjectiveResources;
use App\Models\KeyResult;
use App\Models\Objective;
use Illuminate\Http\Request;
use Notification;
use DateTime;
use App\Models\User;
use App\Notifications\DueObjectiveNotification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;

class ObjectiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public $current_team;
    public $loaded_user_id;
    public $sortingStatus;
    public $search;
    public $sorting;
    public $pagesize;



    public function __construct()
    {
        $this->loaded_user_id = null;
        $this->sortingStatus = 'all';
        $this->sorting = 'all';
        $this->pagesize = 10;
    }



    public function index()
    {
        $this->loaded_user_id = null;
    }

    public function myObjectives()
    {
        $this->loaded_user_id = auth()->user()->id;
        return $this->userBasedObjectives();
    }

    public function allObjectives(Request $request)
    {
        $dates = $this->dateHandler($request);

        $from = $dates['from'];
        $to = $dates['to'];

        $current_team =  auth()->user()->currentTeam;

        $isAdmin = auth()->user()->hasTeamPermission($current_team, 'objectives:read-all');

        // dd($request['status']);
        $renderData['objectives'] = Objective::query()
            ->when(($request['completed'] == '0'), function ($query) {
                $query->where('completed', 0);
            })
            ->when(($request['completed']), function ($query) use ($request) {
                $query->where('completed', $request['completed']);
            })
            ->when((!$isAdmin),function($query){
                $query->where('user_id', auth()->user()->id);
            })
            ->where('team_id', $current_team->id)
            ->whereIn('status', ['1', '0'])
            ->when((strlen($request['search']) > 1), function ($query) use ($request,$current_team) {
                $query->where('name', 'like', '%' . $request['search'] . '%')->orWhere('description', 'like', '%' . $request['search'] . '%')->where('team_id', $current_team->id);
            })
            ->when(($to), function ($query) use ($from, $to) {
                if ($to == 'all') {
                    $to = date('Y-m-d h:i:s', strtotime("$from 10 years"));
                    $query->where('due_date', '<=', $to);
                } else {
                    $query->whereBetween('due_date', [$from, $to]);
                }
            })
            ->orderBy('id', 'DESC')
            ->withCount(['other_key_results as completed_key_result_count' => function ($query) {
                $query->where('completed', 1);
            }])
            ->paginate($this->pagesize);

        return new ObjectiveResources($renderData);
    }


    public function keepOriginal(Request $request)
    {
        $current_team =  auth()->user()->currentTeam;
        $isAdmin = auth()->user()->hasTeamPermission($current_team, 'objectives:read-all');
        if(!$isAdmin){
            abort(401,'Unauthorized');
        }

        $objective = Objective::findOrFail($request['objective_id']);


        $objective->approved = 1;
        $objective->save();

        Objective::where('parent_id', $objective->id)->delete();

        return response()->json(['message' =>'Removed Edited Objective Successfully,Kept Original Objective.', 'status' => true], 200);

    }



    public function keepEdited(Request $request)
    {
        $current_team =  auth()->user()->currentTeam;
        $isAdmin = auth()->user()->hasTeamPermission($current_team, 'objectives:read-all');
        if(!$isAdmin){
            abort(401,'Unauthorized');
        }

        $objective = Objective::findOrFail($request['sub_objective_id']);

        Objective::where('id', $objective->id)->update(['status' => 1, 'approved' => 1]);
        Objective::where('id', $objective->parent_id)->update(['status' => 7, 'approved' => 0]);
        KeyResult::where('objective_id', $objective->parent_id)->update(['objective_id' => $objective->id]);

        return response()->json(['message' =>' Edited Objective Replaced Successfully.', 'status' => true], 200);


    }



    public function userObjectives(Request $request, $user_id)
    {
        $this->loaded_user_id = $user_id;

        $current_team =  auth()->user()->currentTeam;
        $isAdmin = auth()->user()->hasTeamPermission($current_team, 'objectives:read-all');

        $auth_user = auth()->user()->id;

        if(($isAdmin)||($auth_user==$user_id)){
            return $this->userBasedObjectives($request);
        }else{
            return response()->json(['message' =>'You are not authorize load objectives.', 'status' => false], 401);
        }

    }



    public function userDueObjectives(Request $request, $user_id)
    {
        $this->loaded_user_id = $user_id;
        $this->sorting = 'all';
        $this->sortingStatus = '0,2,3';

        return $this->userBasedObjectives($request);
    }

    public function userBasedObjectives(Request $request)
    {

        $dates = $this->dateHandler($request);

        $from = $dates['from'];
        $to = $dates['to'];

        $current_team =  auth()->user()->currentTeam;

        $renderData['objectives'] = Objective::query()
                ->when(($request['completed'] == '0'), function ($query) {
                    $query->where('completed', 0);
                })
                ->when(($request['completed']), function ($query) use ($request) {
                    $query->where('completed', $request['completed']);
                })
            ->where('team_id', $current_team->id)
            ->whereIn('status', ['1', '0'])
            ->when((strlen($request['search']) > 1), function ($query) use ($request,$current_team) {
                $query->where('user_id', $this->loaded_user_id)
                    ->where('name', 'like', '%' . $request['search'] . '%')->orWhere('description', 'like', '%' . $request['search'] . '%')->where('team_id', $current_team->id);
            })
            ->when(($to), function ($query) use ($from, $to) {
                if ($to == 'all') {
                    $to = date('Y-m-d h:i:s', strtotime("$from 10 years"));
                    $query->where('due_date', '<=', $to);
                } else {
                    $query->whereBetween('due_date', [$from, $to]);
                }
            })
            ->where('team_id', $current_team->id)->orderBy('id', 'DESC')
            ->where('user_id', $this->loaded_user_id)
            ->when((!strlen($this->search) > 0), function ($query) {
                // $query->orWhere('allowed_users', 'like', '%,' . $this->loaded_user_id . '%');
            })
            ->withCount(['other_key_results as completed_key_result_count' => function ($query) {
                $query->where('completed', 1);
            }])
            ->paginate($this->pagesize);

        return new ObjectiveResources($renderData);
    }


    public function dateHandler($request)
    {
        $from = date('Y-m-d h:i:s');
        $to = 'all';

        if ($request['due_range'] == 'all') {
            // $to = date('Y-m-d h:i:s', strtotime("$from 10 years"));
            $to = 'all';
        } else if ($request['due_range'] == 'week') {
            $to = date('Y-m-d h:i:s', strtotime("$from +1 week"));
        } else if ($request['due_range'] == 'month') {
            $from = date('Y-m-01 h:i:s');
            $to = date('Y-m-t h:i:s');
        } else if ($request['due_range'] == 'quarter') {
            $quarter = $this->getQuarter(new DateTime());
            // dd();
            $from = date('Y-m-d h:i:s', strtotime($quarter['start']));
            $to = date('Y-m-d h:i:s', strtotime($quarter['end']));
        } else if ($request['due_range'] == 'year') {
            $from = date('Y-01-01 h:i:s');
            $to = date('Y-12-31 h:i:s', strtotime("$from 365 days"));
        }


        return ['from' => $from, 'to' => $to];
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

    public function sendDueObjectiveNotification()
    {
        $user = User::first();

        $details = [];

        Notification::send($user, new DueObjectiveNotification($details));

        // dd('done');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function StoreObjective(Request $request)
    {
        $inputs = $request->all();

        if ($request->has('user_id')) {
            if(!$this->isValidUser($request['user_id'])){
                return response()->json(['message' =>'User has not permissions to create objective', 'status' => false], 401);
            }

        }else{

            $inputs['user_id'] = (int)auth()->user()->id;
        }

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
            'user_id' => 'required',
            'due_date' => 'required|date|after:yesterday',
        ];

        // dd($inputs);

        $current_team =  auth()->user()->currentTeam;

        $validator = Validator::make($inputs, $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => false], 422);
        }


        if (auth()->user()->hasTeamPermission($current_team, 'objective:create')) {
            $team_id = auth()->user()->currentTeam->id;
            $own_user_id = $inputs['user_id'];

            if ((isset($inputs['allowed_users']))&&(is_array($inputs['allowed_users']))) {

                foreach ($inputs['allowed_users'] as $key => $user_id) {
                    if(!$this->isValidUser($user_id)){
                        return response()->json(['message' =>'Team member has not permissions to access objective', 'status' => false], 401);
                    }
                }

                $allowed_user_str =  implode(',', $inputs['allowed_users']);
                $allowed_user_str =  auth()->user()->id . ',' . $allowed_user_str;
                $objective_type = 1;

            } else {
                $allowed_user_str =  auth()->user()->id;
                $objective_type = 0;
            }

            $objectiveArr = [
                'name' => $inputs['name'],
                'user_id' => (int)$own_user_id,
                'team_id' => $team_id,
                'description' => $inputs['description'],
                'objective_type' => $objective_type,
                'due_date' => $inputs['due_date'],
                'completed_note' => '',
                'edit_by_user' => auth()->user()->id,
                'allowed_users' => $allowed_user_str,
                'timer' => '',
                'approved' => 1,
                'status' => 1,
                'parent_id' => 0
            ];

            $newObjectiveData = Objective::updateOrCreate(['id' => ''], $objectiveArr);



            $data['data'] =  Objective::find($newObjectiveData->id);
            return new ObjectiveResources($data);

        }else{
            return response()->json(['message' =>'Unauthorized', 'status' => false], 401);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Objective  $objective
     * @return \Illuminate\Http\Response
     */
    public function ShowObjective($id)
    {
        $renderData[] = Objective::findorFail($id);

        return new ObjectiveResources($renderData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Objective  $objective
     * @return \Illuminate\Http\Response
     */
    public function edit(Objective $objective)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Objective  $objective
     * @return \Illuminate\Http\Response
     */
    public function updateObjective(Request $request, Objective $objective)
    {


        $messages = [
            'name.required' => 'Please fill objective name here.',
            'description.required' => 'Please fill objective description here.',
            'due_date.required' => 'Please fill objective due date here.',
            'completed_note.required_if' => 'Please fill complete note here.',
            // 'user_id.required' => 'Please assign a member to the objective.',
        ];

        $rules = [
            'name' => 'required',
            'description' => 'min:10',
            // 'user_id' => 'required',
            'due_date' => 'required|date',
        ];

        $current_team =  auth()->user()->currentTeam;

        $validator = Validator::make($request->all(), $rules);

        if($current_team->id != $objective->team_id){
            return response()->json(['message' =>'Not allow to update this objective', 'status' => false], 401);
        }

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => false], 422);
        }

        $input = $request->only(['name', 'description', 'due_date','completed']);


         //check has permission to update
         $isAdmin = auth()->user()->hasTeamPermission($current_team, 'objectives:read-all');

        if($isAdmin){
            $objective->update($input);
            $data['data'] = $objective;
            return new ObjectiveResources($data);
        }elseif($objective->user_id == auth()->user()->id){


            $status = 5;
            $approved = 0;
            $parent_id =  $objective->id;
            $team_id = $objective->team_id;
            $user_id = auth()->user()->id;

            $objectiveArr = [
                'name' => $input['name'],
                'user_id' => $user_id,
                'team_id' => $team_id,
                'description' => $input['description'],
                'due_date' => date("Y-m-d H:i:s", strtotime($input['due_date'])),
                'completed_note' => $objective->completed_note,
                'edit_by_user' => auth()->user()->id,
                'approved' => $approved,
                'status' => $status,
                'timer' => $objective->timer,
                'parent_id' => $parent_id,
                'objective_type' => $objective->objective_type,
                'allowed_users' => $objective->allowed_users,
            ];


            if (($objective->name != $objectiveArr['name']) || ($objective->description != $objectiveArr['description']) || ($objective->due_date != $objectiveArr['due_date'])) {
                //create duplicate object with update changes
                $data = array('old_data' => $objective, 'new_data' => $objectiveArr);
                // dd($data);
                Objective::updateOrCreate(['id' => ''], $objectiveArr);

                if (isset($objective->id)) {
                    Objective::updateOrCreate(['id' => $objective->id], ['approved' => 0]);
                }

                return response()->json(['message' =>'Objective Updated Successfully,Notified for Review.', 'status' => true], 200);

            }

        }else{
            return response()->json(['message' => 'Unauthorized', 'status' => false], 401);
        }




    }

    public function statusChangeObjective(Request $request, Objective $objective)
    {
        $messages = [
            'completed.required' => 'Please fill objective status here.',
        ];

        $rules = [
            'completed' => 'required',
        ];

        $current_team =  auth()->user()->currentTeam;

        if($current_team->id != $objective->team_id){
            return response()->json(['message' =>'Not allow to update this objective', 'status' => false], 401);
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => false], 422);
        }


        $input = $request->only(['completed']);

        $isAdmin = auth()->user()->hasTeamPermission($current_team, 'objectives:read-all');

        if($isAdmin || $objective->user_id == auth()->user()->id){
            $objective->update($input);
            $data['data'] = $objective;
            return new ObjectiveResources($data);
        }else{
            return response()->json(['message' => 'Unauthorized', 'status' => false], 401);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Objective  $objective
     * @return \Illuminate\Http\Response
     */
    public function deleteObjective(Request $request,$id)
    {
        $current_team =  auth()->user()->currentTeam;
        $isAdmin = auth()->user()->hasTeamPermission($current_team, 'objectives:read-all');
        $objective = Objective::find($id);

        if($objective){

            if($current_team->id != $objective->team_id){
                return response()->json(['message' =>'Not allow to delete this objective', 'status' => false], 401);
            }

            if($isAdmin || $objective->user_id == auth()->user()->id){
                $objective->delete();
                Objective::where('parent_id', $id)->where('status', 5)->delete();
                return response()->json(['message' =>'Objective Deleted Successfully', 'status' => true], 200);

            }else{
                return response()->json(['message' =>'Not Allow to delete this objective', 'status' => false], 401);
            }

        }else{
            return response()->json(['message' =>'Objective Not Found', 'status' => false], 404);

        }
    }

    private function isValidUser($user_id){
        $user = User::find($user_id);
        $current_team =  auth()->user()->currentTeam;

        if($user){
            if($user->belongsToTeam($current_team)){
                return true;
            }

            return false;
        }else{
            return false;
        }
    }

}
