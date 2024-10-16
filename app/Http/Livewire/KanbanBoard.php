<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Column;

class KanbanBoard extends Component
{
    public $columns;

    public function mount()
    {
        // Ambil kolom beserta tasklist dan tasknya
        $this->columns = Column::with('tasklists.tasks')->get();
    }

    public function render()
    {
        return view('livewire.kanban-board');
    }
}
