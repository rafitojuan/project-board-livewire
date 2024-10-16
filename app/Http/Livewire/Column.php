<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Column extends Component
{
    public $column;

    public function render()
    {
        return view('livewire.column');
    }
}
