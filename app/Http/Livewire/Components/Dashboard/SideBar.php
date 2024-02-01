<?php

namespace App\Http\Livewire\Components\Dashboard;

use Livewire\Component;

class SideBar extends Component
{
    public $canEditTeam;

    public $current_team;

    public function render()
    {

        $this->current_team = auth()->user()->currentTeam;
        $this->canEditTeam = auth()->user()->hasTeamPermission($this->current_team,'settings:edit-team');


        return view('livewire.components.dashboard.side-bar');
    }
}
