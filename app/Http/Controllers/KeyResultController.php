<?php

namespace App\Http\Controllers;

use App\Http\Resources\KeyResult as ResourcesKeyResult;
use App\Models\KeyResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Objective;



class KeyResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        $current_team =  auth()->user()->currentTeam;
        $isAdmin = auth()->user()->hasTeamPermission($current_team, 'objectives:read-all');

        $inputs = $request->all();

        $messages = [
            'content.required' => 'Please fill key result field here.',
            'content.min' => 'It should be more than 10 characters.',
        ];

        $rules = [
            'content' => 'required|min:10',
            'objective_id' => 'required|integer',
            'due_date' => 'date|after:yesterday',

        ];

        $validator = Validator::make($inputs, $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => false], 422);
        }

        //validate objective_id and team_id is readable to that user

        $objective = Objective::find($inputs['objective_id']);

        if(!$objective){
            return response()->json(['message' =>'Objective Not Found', 'status' => false], 404);
        }
        // dd($objective);
        // dd($objective->objective_type);

         if($isAdmin || ($objective->user_id == auth()->user()->id)){


            if($objective->team_id == $current_team->id ){

               //create objective
               $keyResultArr = [
                'content' => $inputs['content'],
                'objective_id' => $inputs['objective_id'],
                'due_date' =>  (isset($inputs['due_date'])) ? $inputs['due_date'] : null,
                'completed' => 0,
                'owner_id' => auth()->user()->id,
                'team_id' => auth()->user()->currentTeam->id,
                'is_team_objective' => $objective->objective_type,
            ];

            $newKeyResultData = KeyResult::updateOrCreate(['id' => ''], $keyResultArr);

            return response()->json(['data'=>$newKeyResultData,'message' =>'Key result created successfully', 'status' => true], 200);

            }else{
                return response()->json(['message' =>'Not allow to create this key result.Unauthorized Team Action', 'status' => false], 401);
            }

        }else{
            return response()->json(['message' =>'You are not authorize to create this keyresult.', 'status' => false], 401);
        }












        /*
        $keyResultArr = [
            'content' => $this->content,
            'objective_id' => $this->objective->id,
            'owner_id' => $this->objective->user_id,
            'team_id' => auth()->user()->currentTeam->id,
            'is_team_objective' => $this->objective->objective_type,
        ];


        ModelKeyResult::updateOrCreate(['id' => $this->keyresult_id], $keyResultArr );

        */
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KeyResult  $keyResult
     * @return \Illuminate\Http\Response
     */
    public function show(KeyResult $keyResult)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KeyResult  $keyResult
     * @return \Illuminate\Http\Response
     */
    public function edit(KeyResult $keyResult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KeyResult  $keyResult
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KeyResult $keyresult)
    {

        $current_team =  auth()->user()->currentTeam;
        $isAdmin = auth()->user()->hasTeamPermission($current_team, 'objectives:read-all');

        if($current_team->id != $keyresult->team_id){
            return response()->json(['message' =>'Not allow to update this keyresult', 'status' => false], 401);
        }

        if($isAdmin || ($keyresult->owner_id == auth()->user()->id)){

            $keyresult->update($request->all());
            $data['data'] = $keyresult;
            return new ResourcesKeyResult($data);

        }

        return response()->json(['message' => 'Unauthorized', 'status' => false], 401);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KeyResult  $keyResult
     * @return \Illuminate\Http\Response
     */
    public function destroy($keyresult)
    {

        $current_team =  auth()->user()->currentTeam;
        $isAdmin = auth()->user()->hasTeamPermission($current_team, 'objectives:read-all');
        $keyresult = KeyResult::find($keyresult);


        if($keyresult){
            if($current_team->id != $keyresult->team_id){
                return response()->json(['message' =>'Not allow to delete this keyresult', 'status' => false], 401);
            }


            if($isAdmin || $keyresult->user_id == auth()->user()->id){
                $keyresult->delete();

                return response()->json(['message' =>'Keyresult Deleted Successfully', 'status' => true], 200);

            }else{
                return response()->json(['message' =>'Not allow to delete this keyresult', 'status' => false], 401);
            }

        }else{
            return response()->json(['message' =>'Keyresult Not Found', 'status' => false], 404);

        }
    }
}
