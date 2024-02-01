<?php

namespace App\Http\Livewire\Scorecards;

use App\Models\Scorecard;
use App\Models\ScorecardHistory;
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Route;


class Create extends Component
{
    use WithPagination;

    public $isOpen, $isEdit, $isCreate;
    public $openType;
    public $title,$description,$user_id,$timer,$kpi_metric,$started_at,$next_due_date;
    public $isAdmin;


    protected $listeners = ['selectedUser'];


    public function mount()
    {

        // $this->isEdit = false;
        // $this->isCreate  = false;
    }




    public function create()
    {
        $this->resetInputFields();
        $this->openModal('create');
        $this->user_id = auth()->user()->id;
    }

    public function store()
    {
        request()->input('user_id', $this->user_id);

        $messages = [
            'title.required' => 'Please fill Title here.',
            'description.required' => 'Please fill Description here.',
            'timer.required' => 'Please fill Recurring Time.',
            'user_id.required' => 'Please assign a Member.',
            'kpi_metric.required' => 'Please fill KPI Goal here.',
            'next_due_date.required' => 'Please fill Start From Date.',
        ];

        $this->validate([
            'title' => 'required',
            'description' => 'min:10',
            'timer' => 'required',
            'user_id' => 'required',
            'kpi_metric' => 'required',
            'next_due_date' => 'required|date|after:today',
        ], $messages);

        $today = date("Y-m-d H:i:s");

        $scoreCardArr = [
            'user_id' => $this->user_id,
            'team_id' =>  auth()->user()->currentTeam->id,
            'timer' => $this->timer,
            'title' => $this->title,
            'description' => $this->description,
            'kpi_metric' => $this->kpi_metric,
            // 'next_due_date' => $this->dueDateTimer($today),
            'next_due_date' => $this->next_due_date,
            'started_at' =>  $today,
            'completed'=> 2
        ];

        $scorecard_data = Scorecard::create($scoreCardArr);
        // dd($scorecard_data);
        $scorecardHistoryArr = [
            'note' =>  'First-'.ucfirst($this->timer).'-'.$this->title,
            'scorecard_id' => $scorecard_data->id,
            'user_id' => $this->user_id,
            'team_id' => auth()->user()->currentTeam->id,
            'completed' => 0,
            'due_date'=> $this->next_due_date
        ];

        ScorecardHistory::create($scorecardHistoryArr);


        $this->closeModal();
        $this->resetInputFields();
        $this->emit('scoreCardAdded');

    }



    protected function dueDateTimer($from)
    {

        if ($this->timer == 'all') {
            $next_due_date = date('Y-m-d h:i:s', strtotime("10 years"));
        } else if ($this->timer == 'weekly') {
            $next_due_date = date('Y-m-d h:i:s', strtotime("$from +1 week"));
        } else if ($this->timer == 'bi-weekly') {
            $next_due_date = date('Y-m-d h:i:s', strtotime("$from +2 week"));
        } else if ($this->timer == 'monthly') {
            $next_due_date = date('Y-m-d h:i:s', strtotime("$from +31 days"));
        } else if ($this->timer == 'quarterly') {
            $next_due_date = date('Y-m-d h:i:s', strtotime("$from +90 days"));
        } else if ($this->timer == 'annual') {
            $next_due_date = date('Y-m-d h:i:s', strtotime("$from +365 days"));
        }

        return $next_due_date;
    }


    public function openModal($type = 'show')
    {
        $this->resetValidation();
        $this->isOpen = true;
        $this->openType = $type;

    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function resetInputFields()
    {
        $this->scorecard_id = '';
        $this->title = '';
        $this->description = '';
        $this->kpi_metric = '';
        $this->timer = '';
        $this->next_due_date = '';
    }

    public function selectedUser($user_id)
    {
        $this->user_id = $user_id;
    }



    public function render()
    {
        $this->isAdmin = auth()->user()->hasTeamPermission(auth()->user()->currentTeam, 'scorecard:read-all');
        return view('livewire.scorecards.create');
    }


}
