<?php

namespace App\Http\Livewire\Components;

use Laravel\Jetstream\Jetstream;
use Livewire\Component;

class UsersDropdown extends Component
{

    public String $field, $selected_user, $off,$owner;



    public function mount()
    {
        $this->selected_user = $this->owner;

    }


    public function render()
    {
        $user = auth()->user();
        $currentTeamID = ($user->currentTeam->id);



        $team = Jetstream::newTeamModel()->findOrFail($currentTeamID);
        return view('livewire.components.users-dropdown',['team'=>$team]);
    }

    public function updatedSelectedUser()
    {
        $this->emit('selectedUser',$this->selected_user); // dd($this->selected_user);
    }

}
