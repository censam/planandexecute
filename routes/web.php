<?php

use App\Http\Livewire\Objectives;
use App\Http\Controllers\ObjectiveController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Livewire\TeamController;
use App\Http\Controllers\TeamInvitationController as ControllersTeamInvitationController;
use App\Http\Livewire\ArchivedObjectives;
use App\Http\Livewire\Scorecards\Edit as ScoreCardEdit;
use App\Http\Livewire\Scorecards\Scorecard;
use App\Http\Livewire\Users;
use App\Models\ChatUser;
use App\Models\Objective;
use App\Notifications\DueObjectiveNotification;
use App\Notifications\UnreadChatNotification;
use Laravel\Jetstream\Http\Controllers\CurrentTeamController;
use Laravel\Jetstream\Jetstream;
use Laravel\Fortify\Contracts\LoginViewResponse;
use Laravel\Jetstream\Http\Controllers\TeamInvitationController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return app(LoginViewResponse::class);
    // return view('welcome');

});


//'auth.teams' middleware added to dashboard
Route::middleware(['auth:sanctum','verified','web'])->group(function(){
    Route::get('dashboard',function () {return view('dashboard'); })->name('dashboard');
    Route::get('objectives', Objectives::class)->name('objectives');
    Route::get('objectives/{id}',  Objectives::class)->name('objectives.show');
    Route::get('scorecards', function () {return view('livewire.scorecards.main'); })->name('scorecards');
    Route::get('scorecards/edit/{id}',ScoreCardEdit::class)->name('scorecards.edit');
    Route::get('due_objectives', Objectives::class)->name('due_objectives');
    Route::get('archived_objectives', Objectives::class)->name('archived_objectives');
    // Route::get('user/{id}', Users::class)->name('user.show');
    Route::get('user/{id}',function () {return view('livewire.users.users'); })->name('user.show');
    Route::get('send', [ObjectiveController::class,'sendDueObjectiveNotification']);

});





Route::group(['middleware' => config('jetstream.middleware', ['web'])], function () {

Route::group(['middleware' => ['auth', 'verified']], function () {

// if (Jetstream::hasTeamFeatures()) {
    Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
    Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');
    Route::put('/current-team', [CurrentTeamController::class, 'update'])->name('current-team.update');

    Route::get('/team-invitations/{invitation}', [ControllersTeamInvitationController::class, 'accept'])
                ->middleware(['signed'])
                ->name('team-invitations.accept');
// }
});

});




Route::get('/notification', function () {

    $from = date('Y-m-d h:i:s',strtotime("3 days"));

    $today_due_objectives_by_user = Objective::whereIn('status',['1','0'])->whereIn('completed',['0','2'])
                                // ->whereBetween('due_date',[$from, $to])
                                ->where('due_date', '<=', $from)
                                ->groupBy('user_id')
                                ->orderBy('due_date','ASC')
                                ->get();


    foreach ($today_due_objectives_by_user as $key => $due_objective) {
        if(isset($due_objective->user->id)){

            if(in_array($due_objective->user->id,['177','178','180','241'])){
                (new DueObjectiveNotification($due_objective))->toMail($due_objective->user);
            }

        }
    }

});

Route::get('/chat_email', function () {

$from = date('Y-m-d h:i:s',strtotime("+1 day"));
$emailchatBox = ChatUser::where('read',0)
->where('created_at', '<=', $from)
->groupBy('to_user_id')
->orderBy('id','asc')->get();
foreach ($emailchatBox as $key =>  $emailChat) {
    if(isset($emailChat->toUser)){

        if(in_array($emailChat->toUser->id,['177','178','180'])){

            (new UnreadChatNotification($emailChat))
            ->toMail($emailChat->toUser);

        }

    }

}




});





