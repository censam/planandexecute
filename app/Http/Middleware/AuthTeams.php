<?php

namespace App\Http\Middleware;

use App\Models\Team;
use Closure;
use Illuminate\Http\Request;

class authTeams
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $teamIDs = explode(',',env('TEAMS'));
        $headTeam = Team::whereIn('id',$teamIDs)->get();

        foreach ($headTeam as $key => $team) {
            if(auth()->user()->hasTeamRole($team, 'admin')){

            }else{
                auth()->user()->switchTeam($team);
            }
            # code...
        }
        //  dd(auth()->user()->teamRole($headTeam));
        // dd(auth()->user()->currentTeam);
        // dd(auth()->user()->allTeams());
        // dd(auth()->user()->ownedTeams);
        // dd(auth()->user()->teams );




        return $next($request);
    }
}
