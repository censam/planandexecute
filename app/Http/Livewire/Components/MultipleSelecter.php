<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;

class MultipleSelecter extends Component
{
    public String $field;
    public $array;

    public function mount()
    {
        // $this->array = $this->array;

    }
    public function render()
    {


        return view('livewire.components.multiple-selecter');
    }
}
