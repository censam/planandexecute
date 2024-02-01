<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatBoxController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\KeyResultController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ObjectiveController;
use App\Http\Controllers\TeamController;
use Laravel\Jetstream\Http\Controllers\Livewire\PrivacyPolicyController;
use Laravel\Jetstream\Http\Controllers\Livewire\TermsOfServiceController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
//
Route::get('/privacy-policy', [PrivacyPolicyController::class, 'show']);
Route::get('/terms-and-conditions', [TermsOfServiceController::class, 'show']);
//
Route::post('/forgot-password', [AuthController::class, 'sendPasswordLink']);



Route::get('/notify', [AuthController::class, 'notifyUser']);




Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::put('/update-profile', [AuthController::class, 'updateProfile']);

    Route::put('/password-change', [AuthController::class, 'changePassword'])->name('user-password.update');

    Route::get('/my-objectives', [ObjectiveController::class, 'myObjectives']);
    Route::get('/user-objectives/{user_id}', [ObjectiveController::class, 'userObjectives']);
    Route::get('/all-objectives', [ObjectiveController::class, 'allObjectives']);
    Route::get('/objective/{user_id}', [ObjectiveController::class, 'ShowObjective']);
    Route::get('/user-due-objectives/{user_id}', [ObjectiveController::class, 'userDueObjectives']);
    Route::delete('/delete-objective/{id}', [ObjectiveController::class, 'deleteObjective']);
    Route::put('/objective-update/{objective}', [ObjectiveController::class, 'updateObjective']);
    Route::put('/objective-status-change/{objective}', [ObjectiveController::class, 'statusChangeObjective']);
    Route::post('/create-objective', [ObjectiveController::class, 'StoreObjective']);
    Route::put('/keep-original-objective', [ObjectiveController::class, 'keepOriginal']);
    Route::put('/keep-edited-objective', [ObjectiveController::class, 'keepEdited']);


    Route::get('/my-teams', [TeamController::class, 'myTeams']);
    Route::get('/current-team-members', [TeamController::class, 'currentTeamMembers']);
    Route::post('/switch-team', [TeamController::class, 'switchTeam']);
    Route::post('/create-team', [TeamController::class, 'createTeam']);
    Route::delete('/delete-team', [TeamController::class, 'deleteTeam']);
    Route::put('/edit-team', [TeamController::class, 'editTeam']);
    Route::post('/invite-team-member', [TeamController::class, 'inviteTeamMember']);
    Route::get('/invited-members', [TeamController::class, 'invitedMemberList']);
    Route::delete('/remove-team-invitations/{invitation}', [TeamController::class, 'removeTeamInvitation']);
    Route::delete('/remove-team-member/{team}/members/{user}', [TeamController::class, 'removeTeamMember']);


    Route::get('/load-chat/{id}', [ChatBoxController::class, 'loadChat']);
    Route::post('/send-chat', [ChatBoxController::class, 'sendChatMessage']);
    Route::get('/chat-notifications', [ChatBoxController::class, 'UnreadChatMessages']);
    Route::get('/unread-messages/{objectibe_id}', [ChatBoxController::class, 'UnreadObjectiveChatMessages']);
    Route::get('/read-message/{id}', [ChatBoxController::class, 'updateAsread']);
    Route::get('/load-chat-history/{id}/{count}', [ChatBoxController::class, 'loadChatHistory']);
    Route::get('/load-emoji', [ChatBoxController::class, 'loadEmoji']);


    Route::get('/dashboard', [DashBoardController::class, 'index']);
    Route::get('/latest_activities', [DashBoardController::class, 'allActivities']);

    Route::apiResources([
        'keyresult' => KeyResultController::class,
    ]);
});
