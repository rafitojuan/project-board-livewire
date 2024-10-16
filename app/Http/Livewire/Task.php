<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Task extends Component
{
    public $task;
    public $showNestedBoard = false;

    public function mount($task)
    {
        $this->task = $task;
    }

    public function toggleNestedBoard()
    {
        $this->showNestedBoard = !$this->showNestedBoard;
    }

    public function render()
    {
        return view('livewire.task');
    }
}
