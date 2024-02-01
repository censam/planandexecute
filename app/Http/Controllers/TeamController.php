<?php

namespace App\Http\Controllers;

use App\Http\Resources\Team as TeamResources;
use App\Models\Team;
use App\Models\TeamInvitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Actions\ValidateTeamDeletion;
use Laravel\Jetstream\Contracts\DeletesTeams;
use Laravel\Jetstream\Contracts\UpdatesTeamNames;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Contracts\InvitesTeamMembers;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;
use Laravel\Jetstream\Contracts\AddsTeamMembers;
use Laravel\Jetstream\Contracts\RemovesTeamMembers;



class TeamController extends Controller
{


    public function myTeams()
    {
        $renderData['my_teams'] = auth()->user()->allTeams();
        $renderData['current_team'] = auth()->user()->currentTeam;

        return new TeamResources($renderData);
    }



    public function currentTeamMembers()
    {
        $renderData['all_users'] = auth()->user()->currentTeam->allUsers();
        $renderData['current_team'] = auth()->user()->currentTeam;

        return new TeamResources($renderData);
    }

    public function switchTeam(Request $request)
    {
        $inputs = $request->all();
        $user = auth()->user();
        // dd($request['all']);
        $team = Team::find($inputs['team_id']);

        if(!$team){
            return response()->json(['message' => 'Team Not Found', 'status' => false], 404);

        }
        $isMember = $team->hasUser($user);

        if ($isMember) {
            $user->switchTeam($team);
            $renderData['current_team'] = auth()->user()->currentTeam;
            return new TeamResources($renderData);
        } else {
            return response()->json(['message' => 'Not Allow to switch to this team', 'status' => false], 401);
        }
    }



    public function createTeam(Request $request)
    {
        //validate team name with existname, limit , required
        $inputs = $request->all();

        $messages = [
            'name.required' => 'Please fill Team name here.',
        ];

        $rules = [
            'name' => 'required|min:3'
        ];

        $validator = Validator::make($inputs, $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => false], 422);
        }

        $auth_user = auth()->user();

        //check team name already exist to this user
        $existTeam = Team::where('name', $request['name'])->first();

        if ($existTeam) {
            return response()->json(['errors' => ['name' => ['You already have taken this team name']], 'status' => false], 422);
        } else {

            //create team
            $team = $auth_user->ownedTeams()->save(Team::forceCreate([
                'user_id' => $auth_user->id,
                'name' => $inputs['name'],
                'personal_team' => false,
            ]));

            return response()->json(['data' => $team, 'message' => 'Your team `' . $inputs['name'] . '` created successfully', 'status' => true], 200);
        }


    }


    public function editTeam(Request $request)
    {
        //validate team name with existname, limit , required
        $inputs = $request->all();

        $messages = [
            'name.required' => 'Please fill Team name here.',
        ];

        $rules = [
            'name' => 'required|min:3'
        ];

        $validator = Validator::make($inputs, $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => false], 422);
        }

        $auth_user = auth()->user();

        //check team name already exist to this user
        $existTeam = Team::where('name', $request['name'])->first();

        if ($existTeam) {
            return response()->json(['errors' => ['name' => ['You already have taken this team name']], 'status' => false], 422);
        } else {
            if ($auth_user->ownsTeam($auth_user->currentTeam)) {
                $team = Jetstream::newTeamModel()->findOrFail($auth_user->currentTeam->id);

                app(UpdatesTeamNames::class)->update($request->user(), $team, $request->all());

            }else{
            return response()->json(['message' => "You have not authorized to update this team", 'status' => false], 401);

            }
        }
    }



    public function inviteTeamMember(Request $request)
    {

        //validate email and role
        $messages = [
            'email.required' => 'Please fill Team name here.',
        ];

        $rules = [
            'email' => 'required|email|min:3',
            'role' => [
                'required',
                Rule::in(['admin', 'team_members', 'super_admin']),
            ]
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => false], 422);
        }




        //validate email exist in current team
        $isUserExist =  $this->isValidEmail($request['email']);



        if($isUserExist){
            return response()->json(['message' => "User is already exist in this team.", 'status' => false], 401);
        }



        //if inviation exist
        $checkAlreadyInvited = TeamInvitation::where('email', $request['email'])->where('team_id',$request->user()->currentTeam->id)->first();

        if($checkAlreadyInvited){
            return response()->json(['message' => "Invitation is already sent.To resend it,  remove email in pending invitations list", 'status' => false], 401);
        }else{
            //if not send team invitation
        $team = $request->user()->currentTeam;
        if (Features::sendsTeamInvitations()) {
            app(InvitesTeamMembers::class)->invite(
                $request->user(),
                $team,
                $request->email ?: '',
                $request->role
            );
        } else {
            app(AddsTeamMembers::class)->add(
                $request->user(),
                $team,
                $request->email ?: '',
                $request->role
            );
        }

        return response()->json(['message' => 'Invitation Sent Successfully.Please Check Your email', 'status' => true], 200);


        }

    }

    public function invitedMemberList(Request $request)
    {

        $membersInvited = TeamInvitation::where('team_id',$request->user()->currentTeam->id)->get();

        if($membersInvited->count()){
            return response()->json(['data'=>$membersInvited,'message' => "Invited members list", 'status' => true], 200);
        }else{
            return response()->json(['message' => "Invited Team Members Not Found", 'status' => false], 404);

        }
    }



    private function isValidEmail($email){
        $user = User::where('email', $email)->first();
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


    public function deleteTeam()
    {
        $auth_user = auth()->user();
        //user can delete only currently switched team


        //if it is a personal team of your even you cannot delete it
        if ($auth_user->currentTeam->id == $auth_user->personalTeam()->id) {
            return response()->json(['message' => 'Not Allow to delete your personal team.', 'status' => false], 401);
        }



        //check team is owned to auth user
        if ($auth_user->ownsTeam($auth_user->currentTeam)) {

            $team = Jetstream::newTeamModel()->findOrFail($auth_user->currentTeam->id);

            app(ValidateTeamDeletion::class)->validate(auth()->user(), $team);

            $deleter = app(DeletesTeams::class);

            $deleter->delete($team);

            return response()->json(['data'=>$team,'message' => 'Your Team Deleted Successfully.', 'status' => true], 200);


        } else {
            return response()->json(['message' => "You have not authorized to delete this team", 'status' => false], 401);
        }
    }



    public function removeTeamInvitation(Request $request, $invitation)
    {
        $teamInvitation  = TeamInvitation::find($invitation);

        if($teamInvitation){

            if (! Gate::forUser($request->user())->check('removeTeamMember', $teamInvitation->team)) {
                throw new AuthorizationException;
            }

            $teamInvitation->delete();

            return response()->json(['message' => 'Team Invitation Deleted Successfully.', 'status' => true], 200);

        } else {
            return response()->json(['message' => "You have not authorized to delete this invitation", 'status' => false], 401);
        }


    }


    public function removeTeamMember(Request $request, $teamId, $userId)
    {
        $team = Jetstream::newTeamModel()->find($teamId);

        if(!$team){
            return response()->json(['message' => 'Team Not Found', 'status' => false], 404);
        }

        $user = User::find($userId);

        if(!$user){
            return response()->json(['message' => 'User Not Found', 'status' => false], 404);
        }


        $result = app(RemovesTeamMembers::class)->remove(
            $request->user(),
            $team,
            $user,
        );

        return response()->json(['message' => 'Team member removed successfully', 'status' => true], 200);

    }
}
