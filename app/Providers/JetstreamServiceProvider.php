<?php

namespace App\Providers;

use App\Actions\Jetstream\AddTeamMember;
use App\Actions\Jetstream\CreateTeam;
use App\Actions\Jetstream\DeleteTeam;
use App\Actions\Jetstream\DeleteUser;
use App\Actions\Jetstream\InviteTeamMember;
use App\Actions\Jetstream\RemoveTeamMember;
use App\Actions\Jetstream\UpdateTeamName;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configurePermissions();

        Jetstream::createTeamsUsing(CreateTeam::class);
        Jetstream::updateTeamNamesUsing(UpdateTeamName::class);
        Jetstream::addTeamMembersUsing(AddTeamMember::class);
        Jetstream::inviteTeamMembersUsing(InviteTeamMember::class);
        Jetstream::removeTeamMembersUsing(RemoveTeamMember::class);
        Jetstream::deleteTeamsUsing(DeleteTeam::class);
        Jetstream::deleteUsersUsing(DeleteUser::class);
    }

    /**
     * Configure the roles and permissions that are available within the application.
     *
     * @return void
     */
    protected function configurePermissions()
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::role('super_admin', __('Super Admin'), [
            // 'create','read','update','delete',
            'user:create','user:read','user:update','user:delete',
            'objectives:read-all',
            'scorecards:read-all',
            'statistics:read-all',
            'settings:edit-team',
            'user:addToTeam',
            'objective:create','objective:read','objective:update','objective:delete',
            'scorecard:create','scorecard:read','scorecard:update','scorecard:delete',
        ])->description(__('Super Admin can perform any action.'));


        Jetstream::role('admin', __('Admin'), [
            // 'create','read','update','delete',
            'user:create','user:read','user:update','user:delete',
            'objectives:read-all',
            'scorecards:read-all',
            'statistics:read-all',
            'settings:edit-team',
            'user:addToTeam',
            'objective:create','objective:read','objective:update','objective:delete',
            'scorecard:create','scorecard:read','scorecard:update','scorecard:delete',
        ])->description(__('Admin can create Users.View Team Based Analytics'));

        Jetstream::role('team_members', __('Members'), [
            // 'read','create','update',
            'objective:create','objective:read','objective:delete',
            'scorecard:create','scorecard:read',
        ])->description(__('Team Members can read objectives and execute their objectives.'));
    }
}
