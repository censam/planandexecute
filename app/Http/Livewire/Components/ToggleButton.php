<?php

namespace App\Http\Livewire\Components;

use App\Models\Objective;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class ToggleButton extends Component
{
    public Model $model;

    public String $field, $on, $off;

    public String $color = 'gray';

    public Int $width = 24;

    public String $field_id;

    public $current_status;

    public bool $isActive;

    public String $designTemplate = 'bootstrap';

    public bool $hasTimeStamp;



    public function mount()
    {
        $this->isActive = $this->model->getAttribute($this->field);
        $this->field_id = $this->model->getAttribute('id');
        $this->current_status = ($this->isActive)?$this->on:$this->off;
        $this->hasTimeStamp = false;

    }

    public function updating($field,$value)
    {
        $this->model->setAttribute($this->field,$value)->save();


        if($this->hasTimeStamp){
            if($value==1){
             $this->model->setAttribute($this->field.'_at', date("Y-m-d H:i:s"))->save();
         }else{
                $this->model->setAttribute($this->field.'_at', null)->save();
                $this->model->setAttribute($this->field.'_note', null)->save();
            }
         }

         //This is regarding Progormatic prompts
         //when keyresults status change
         $this->updateObjectiveStatus($value);



        $this->emit('update_not_approve_count');
        $this->emit('scoreCardAdded');
    }


    public function updateObjectiveStatus($toggleValue)
    {

        if($this->model->getTable()=='key_results'){

        $objectiveID = $this->model->getAttribute('objective_id');
        $objective = Objective::query()
            ->where('id',$objectiveID)->withCount(['other_key_results as completed_key_result_count' => function ($query) {
            $query->where('completed', 1);
         }])->first();

         $completed_key_results = $objective->completed_key_result_count;
         $all_keyresults = $objective->other_key_results->count();

        //means all key results completed
         if($completed_key_results==$all_keyresults){
            //trigger popup for objective 'complete' prompt
            $data = ['id'=>$objectiveID,'completed'=>1];
            $this->emitTo('objectives','ObjectiveChangedkeyresultPopup',$data);

         }else if($completed_key_results>0){
            if($objective->completed == 0){
            $data = ['id'=>$objectiveID,'completed'=>2];
            $this->emitTo('objectives','ObjectiveChangedkeyresultPopup',$data);
            }

         }

         }

    }

    public function render()
    {
        return view('livewire.components.toggle-button');
    }


}
