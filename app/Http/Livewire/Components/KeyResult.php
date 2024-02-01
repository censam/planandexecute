<?php

namespace App\Http\Livewire\Components;
use App\Models\KeyResult as ModelKeyResult;

use Livewire\Component;

class KeyResult extends Component
{

    protected $listeners = ['highlight'];

    public $objective , $objective_id , $content, $viewtype , $keyresult, $keyresult_id, $assign_user_id;
    public $highlight_id;
    public $isKeyResultOpen;
    public $deleteConfirmedKeyResult;


    public function mount(){
        $this->assign_user_id = '';
        $this->isKeyResultOpen = false;
        $this->deleteConfirmedKeyResult = 0;
    }


    public function render()
    {
       return view('livewire.components.key-result');
    }


    public function highlight($id)
    {

        $this->highlight_id = $id;
    }

    public function confirmKeyResultDelete($id)
    {
        $this->isKeyResultOpen = true;
        $this->deleteConfirmedKeyResult = $id;
    }


    public function addKeyResult()
    {

        $messages = [
            'content.required' => 'Please fill key result text field here.',
            'content.min' => 'It should be more than 10 characters.',
        ];

        $this->validate([
            'content' => 'required|min:10',
        ],$messages);


        $keyResultArr = [
            'content' => $this->content,
            'objective_id' => $this->objective->id,
            'owner_id' => $this->objective->user_id,
            'team_id' => auth()->user()->currentTeam->id,
            'is_team_objective' => $this->objective->objective_type,
        ];


        ModelKeyResult::updateOrCreate(['id' => $this->keyresult_id], $keyResultArr );

        $this->resetInputFields();
        $this->emit('taskResultAdded');
    }

    public function resetInputFields()
    {
        $this->keyresult_id = '';
        $this->content = '';
    }

    public function delete($id)
    {

        ModelKeyResult::find($id)->delete();

        $this->emit('taskResultAdded');

    }


}
