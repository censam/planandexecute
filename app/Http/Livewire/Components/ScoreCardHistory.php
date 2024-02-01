<?php

namespace App\Http\Livewire\Components;


use App\Models\ScorecardHistory as ModelsScorecardHistory;
use Livewire\Component;

class ScoreCardHistory extends Component
{
    public $scorecard , $scorecard_id , $note, $scorecardHistory, $scorecardHistory_id, $due_date, $completed_at, $completed;
    public $viewtype;
    public $isAdmin;


    public function render()
    {
        $this->isAdmin = auth()->user()->hasTeamPermission(auth()->user()->currentTeam, 'scorecard:read-all');
        return view('livewire.components.score-card-history');
    }


    public function addScoreCardHistory()
    {

        $messages = [
            'note.required' => 'Please fill note here.',
            'note.min' => 'It should be more than 5 characters.',
        ];

        $this->validate([
            'note' => 'required|min:5',
        ],$messages);


        $scorecardHistoryArr = [
            'note' => $this->note,
            'scorecard_id' => $this->scorecard->id,
            'user_id' => $this->scorecard->user_id,
            'team_id' => auth()->user()->currentTeam->id,
        ];

        ModelsScorecardHistory::updateOrCreate(['id' => $this->scorecardHistory_id],$scorecardHistoryArr );

        $this->resetInputFields();
        $this->emit('scoreCardAdded');
    }


    public function delete($id)
    {

        ModelsScorecardHistory::find($id)->delete();

        session()->flash('scorecard_history_msg','ScoreCard Record Removed.');

        $this->emit('scoreCardAdded');

    }


    public function resetInputFields()
    {
        $this->scorecard_id = '';
        $this->note = '';
    }

}
