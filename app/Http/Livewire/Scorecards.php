<?php

namespace App\Http\Livewire;

use App\Models\Scorecard;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;


class Scorecards extends Component
{
    use WithPagination;

    public $pagesize;
    public $sortingTimer;
    public $sorting;
    public $scorecard_id,$title,$user_id,$timer,$description, $kpi_metric,$next_due_date,$started_at,$current_scorecard;
    public $isOpen;
    public $openType;
    public $confirming;
    public $scorecard_message;
    public $loaded_route;
    public $loaded_user_id;
    public $isAdmin;



    protected function getListeners()
    {
        return ['scoreCardAdded'=>'render','selectedUser'];
    }


    public function mount()
    {
        $this->sortingTimer = 'all';
        $this->sorting = 'all';
        $this->pagesize = 9;
        $this->openType = 'show';
        $this->loaded_route = Route::currentRouteName();



        if (isset(Route::current()->parameters['id']) && (Route::currentRouteName()=='user.show')) {
            $this->loaded_user_id = request()->route()->parameters['id'];
        } else {
            $this->loaded_user_id = auth()->user()->id;
        }
    }


    public function update()
    {
        request()->input('user_id', $this->user_id);

        $messages = [
            'title.required' => 'Please fill Title here.',
            'description.required' => 'Please fill Description here.',
            'timer.required' => 'Please fill Recurring Time.',
            'user_id.required' => 'Please assign a Member.',
            'kpi_metric.required' => 'Please fill KPI Goal here.',
        ];

        $this->validate([
            'title' => 'required',
            'description' => 'min:10',
            'timer' => 'required',
            'user_id' => 'required',
            'kpi_metric' => 'required',
        ], $messages);

        $today = date("Y-m-d H:i:s");

        $scoreCardArr = [
            'user_id' => $this->user_id,
            'team_id' =>  auth()->user()->currentTeam->id,
            'timer' => $this->timer,
            'title' => $this->title,
            'description' => $this->description,
            'kpi_metric' => $this->kpi_metric,
            'next_due_date' => $this->next_due_date,
            'started_at' => $this->started_at
        ];


        Scorecard::where('id', $this->scorecard_id)->update($scoreCardArr);

        $this->closeModal();
        $this->resetInputFields();
        $this->emit('scoreCardAdded');

        $this->scorecard_message = [
            'color' => 'green',
            'count' => 1,
            'message' => 'Scorecard Updated Successfully.'
        ];


    }


    public function selectedUser($user_id)
    {
        $this->user_id = $user_id;
    }



    public function edit($id)
    {
        $this->resetInputFields();
        $this->action($id);
        $this->openModal('edit');
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


    public function action($id)
    {
        $scoreCard = Scorecard::findOrFail($id);
        $this->scorecard_id = $id;
        $this->title = $scoreCard->title;
        $this->user_id = $scoreCard->user_id;
        $this->description = $scoreCard->description;
        $this->timer = $scoreCard->timer;
        $this->kpi_metric = $scoreCard->kpi_metric;
        $this->next_due_date = Carbon::parse($scoreCard->next_due_date)->format('Y-m-d');
        $this->started_at = $scoreCard->started_at;
        $this->current_scorecard = $scoreCard;

        // dd($scoreCard);
    }

    public function resetInputFields()
    {
        $this->current_scorecard = '';
        $this->scorecard_id = '';
        $this->title = '';
        $this->user_id = '';
        $this->description = '';
        $this->timer = '';
        $this->kpi_metric = '';
        $this->next_due_date = '';
        $this->started_at = '';
    }



    public function render()
    {
        $this->isAdmin = auth()->user()->hasTeamPermission(auth()->user()->currentTeam, 'scorecard:read-all');
        $scoreCards = $this->loadScoreCards();
        $this->emit('ScorecardStatisticsUpdated');
        $options = array('1' => 'Finished', '0' => 'Not Started', '2' => 'Recurring');
        return view('livewire.scorecards',compact('scoreCards','options'));
    }






    protected function dueDateTimer($from)
    {

        if ($this->sorting == 'all') {
            $to = date('Y-m-d h:i:s', strtotime("10 years"));
        } else if ($this->sorting == 'weekly') {
            $to = date('Y-m-d h:i:s', strtotime("$from +1 week"));
        } else if ($this->sorting == 'bi-weekly') {
            $to = date('Y-m-d h:i:s', strtotime("$from +2 week"));
        } else if ($this->sorting == 'monthly') {
            $to = date('Y-m-d h:i:s', strtotime("$from +31 days"));
        } else if ($this->sorting == 'quarterly') {
            $to = date('Y-m-d h:i:s', strtotime("$from +90 days"));
        } else if ($this->sorting == 'annual') {
            $to = date('Y-m-d h:i:s', strtotime("$from +365 days"));
        }

        return $to;
    }


    public function loadScoreCards()
    {
        $this->isAdmin();

        $from = date('Y-m-d h:i:s');

        $to = $this->dueDateTimer($from);

        $current_team =  auth()->user()->currentTeam;

        if (($this->isAdmin()) && ($this->loaded_route != 'user.show')) {
            return Scorecard::query()->when(($this->sortingTimer != 'all'), function ($query) {
                        $query->where('timer', $this->sortingTimer);
                    })->where('team_id', $current_team->id)->where('next_due_date', '<=', $to)->orderBy('next_due_date', 'ASC')
                    ->withCount(['histories as completed_histories_count' => function ($query) {
                        $query->where('completed', 1);
                    }])
                    ->withCount(['histories as incompleted_histories_count' => function ($query) {
                        $query->where('completed', 0);
                    }])
                    ->paginate($this->pagesize);

        }else{
            return Scorecard::query()->when(($this->sortingTimer != 'all'), function ($query) {
                $query->where('timer', $this->sortingTimer);
            })->where('team_id', $current_team->id)->where('user_id',$this->loaded_user_id)->where('next_due_date', '<=', $to)->orderBy('next_due_date', 'ASC')
            ->withCount(['histories as completed_histories_count' => function ($query) {
                $query->where('completed', 1);
            }])
            ->withCount(['histories as incompleted_histories_count' => function ($query) {
                $query->where('completed', 0);
            }])
            ->paginate($this->pagesize);


        }

    }


    public function confirmDelete($id)
    {
        $this->confirming = $id;
    }

    public function notConfirmdelete()
    {
        $this->confirming = 0;
    }


    public function delete($id)
    {
        Scorecard::find($id)->delete();


        $this->scorecard_message = [
            'color' => 'red',
            'count' => 1,
            'message' => 'Scorecard Deleted Successfully'
        ];
    }


    public function isAdmin()
    {
        return auth()->user()->hasTeamPermission(auth()->user()->currentTeam, 'scorecard:read-all');
    }


}
