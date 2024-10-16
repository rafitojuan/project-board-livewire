<?php

namespace App\Http\Livewire;

use Livewire\Component;

class KanbanTasklist extends Component
{
    public $tasklist;

    public function render()
    {
        return view('livewire.task-list');
    }
}
