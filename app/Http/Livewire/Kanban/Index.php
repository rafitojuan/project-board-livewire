<?php

namespace App\Http\Livewire\Kanban;

use Livewire\Attributes\Title;
use Livewire\Component;


#[Title('Kanban Board')]
class Index extends Component
{

    public function save() {}



    public function render()
    {
        return view('livewire.kanban.index');
    }
}
