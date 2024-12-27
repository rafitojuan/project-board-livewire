<?php

namespace App\Http\Livewire;

use App\Models\Column;
use App\Models\Team;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class AddColumn extends Component
{
    use LivewireAlert;
    public $columnName;
    public $teamId;

    public function mount($id)
    {
        $this->fetchTeamData($id);
    }

    public function fetchTeamData($id)
    {
        $this->teamId = Team::where('id', $id)->first();
        return $this->teamId;
    }

    public function addColumn()
    {
        $this->validate([
            'columnName' => 'required|min:3',
        ]);

        $column = Column::create([
            'name' => $this->columnName,
        ]);

        $this->dispatch('close-columnModal', ['modalName' => 'modalColumn']);
        $this->reset();
        $this->alert('success', 'Column ditambahkan', [
            'position' => 'top-end',
        ]);
        $this->dispatch('columnAdded');
    }

    public function openColumnModal()
    {
        $this->dispatch('column-modal', ['modalName' => 'modalColumn']);
    }
    public function render()
    {
        return view('livewire.add-column', [
            'team' => $this->teamId,
        ]);
    }
}
