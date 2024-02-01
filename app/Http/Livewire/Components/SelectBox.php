<?php

namespace App\Http\Livewire\Components;

use Illuminate\Database\Eloquent\Model;

use Livewire\Component;

class SelectBox extends Component
{
    public Model $model;

    public $options;

    public $message;

    public $current_selected;

    public $selecting;

    public $field;

    public bool $hasTimeStamp;

    public function mount()
    {
        $this->selecting = $this->model->getAttribute($this->field);
        $this->field_id = $this->model->getAttribute('id');
        $this->hasTimeStamp = false;
        $this->message = '';
    }


    public function render()
    {
        // $this->hasTimeStamp = false;
        return view('livewire.components.select-box');
    }


    public function updating($field,$value)
    {
       $this->message = 'updating';

       $this->model->setAttribute($this->field,$value)->save();

       $this->emit('update_not_approve_count');

       if($this->hasTimeStamp){
           if($value==1){
            $this->model->setAttribute($this->field.'_at', date("Y-m-d H:i:s"))->save();
        }else{
               $this->model->setAttribute($this->field.'_at', null)->save();
               $this->model->setAttribute($this->field.'_note', null)->save();
           }
        }else{

        }


        sleep(2);
        $this->message = 'updated';


    // $this->model->setAttribute($this->field,$value)->save();


    }


}
