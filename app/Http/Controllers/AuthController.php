<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Jetstream;
use Laravel\Fortify\Rules\Password;
use Illuminate\Support\Facades\DB;
use App\Models\Team;
use Laravel\Fortify\Contracts\PasswordUpdateResponse;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;
use Illuminate\Contracts\Support\Responsable;
use Laravel\Fortify\Fortify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password as PasswordReset;
use Laravel\Fortify\Contracts\SuccessfulPasswordResetLinkRequestResponse;
use Illuminate\Contracts\Auth\PasswordBroker;
use Laravel\Fortify\Contracts\FailedPasswordResetLinkRequestResponse;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Illuminate\Http\JsonResponse;
use App\Http\Traits\PushNotificationsTrait;



class AuthController extends Controller
{

    use PushNotificationsTrait;

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', new Password, 'confirmed'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'status' => false], 422);
        }

        $user = DB::transaction(function () use ($request) {
            return tap(User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]), function (User $user) {
                $this->createTeam($user);
            });
        });

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }


    protected function createTeam(User $user)
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0] . "'s Personal Team",
            'personal_team' => true,
        ]));
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        if($request['device_id']){
            User::where('id', $user->id)->update(['device_id' => $request['device_id']]);
            $user->device_id = $request['device_id'];
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    public function logout(Request $request)
    {
        return $request->user()->currentAccessToken()->delete();
    }


    public function me(Request $request)
    {
        return $request->user();
    }


    public function changePassword(Request $request, UpdatesUserPasswords $updater)
    {
        $updater->update($request->user(), $request->all());
        return response()->json(['message' => 'Password Updated Successfully.', 'status' => true], 200);
    }

    public function sendPasswordLink(Request $request): Responsable
    {
        $request->validate([Fortify::email() => 'required|email']);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = $this->broker()->sendResetLink(
            $request->only(Fortify::email())
        );

        return $status == PasswordReset::RESET_LINK_SENT
            ? app(SuccessfulPasswordResetLinkRequestResponse::class, ['status' => $status])
            : app(FailedPasswordResetLinkRequestResponse::class, ['status' => $status]);
    }

    protected function broker(): PasswordBroker
    {
        return PasswordReset::broker(config('fortify.passwords'));
    }


    public function updateProfile(Request $request,UpdatesUserProfileInformation $updater) {
        $updater->update($request->user(), $request->all());


        return $request->wantsJson()
            ? new JsonResponse(['message' => 'Profile Updated Successfully.', 'status' => true], 200)
            : back()->with('status', 'profile-information-updated');
    }

    public function notifyUser(){

        // $user = User::where('id', $request->id)->first();

        $notification_id = 'f7bLTzypkEQcnMUNc5P2HS:APA91bHBn9QWiXaasqEmoB55Q0i01qQa0qZ5uYVeSvDCVgLL6jppw457IekOYhDZHzfPQz4zBkO86iRFkCDtZlfslrgj4uX8o-M25siLO1A-ABSsnnWU41s3LBNLNbntOkjmY-sZet86';
        // $notification_id = 'eyGEf-GBQwafSdjp00FVmB:APA91bGgC3oR6mapNperg6YbquNyVT2mZkcBS-YrVUgn_0qwaDMYsHp8-Ihe6_0167UFNsbEqD49eA_IjxGXacyoTaCsPz9YvaSISU-Gi-BRqZLy12xGjYOn7Th92qsC3psHWUdQHrFF';
        // $notification_id = 'fmKszHqtTDepbMg7cvsP7N:APA91bHz3ivHoJ25AhNeM_960PMUDR_fDfjvWoABET73Namw60xfXU0lXlCEFSwr3fPMYyQ11DrN47H2dqNBPJKM0wY3W0ielI1nGcQHJhbjN3alRsQb8sL-5dSQ2bjE08SXndz2WT_i';

        $title = "Greeting Notification ,Push Notifications Working Now";
        $message = "Have good day!";
        $id =1;
        $type = "basic";

        $res = $this->sendPushNotification($notification_id, $title, $message, $id,$type);
        var_dump($res);
        if($res == 1){

           // success code

        }else{

          // fail code
        }


     }
}
