<?php

namespace App\Http\Livewire\Scorecards;

use Livewire\Component;

class Edit extends Component
{

    public $isOpen;
    public $user_id;




    public function render()
    {
        $this->user_id = 1;
        return view('livewire.scorecards.edit');
    }
}
