<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Column;
use App\Models\Tasklist;
use App\Models\TasklistColumn;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;

#[Title('Kanban')]

class Kanban extends Component
{
    use LivewireAlert;

    public $columns;
    public $tasklistColumnName;
    public $currentTasklist;
    public $newTasklistName;
    public $newTasklistCompany;
    public $location = '';
    public $newTasklistStartDate;
    public $newTasklistEndDate;
    public $newTasklistValue;
    public $editingColumn;
    public $newTaskName;
    public $editingTasklistColumn;
    public $tasklistId;
    public $tasklistColumnId;
    public $newTasklistUrl;
    public $newTasklistContract;
    public $tasklistPengadaan = 'pl';
    public $contractSignDate;

    // protected $rules = [
    //     'newTasklistName' => 'required|min:3',
    //     'newTasklistCompany' => 'required|string',
    //     'location' => 'nullable|string',
    //     'newTasklistValue' => 'nullable|numeric',
    //     'newTaskName' => 'required|min:3',
    //     'newTasklistStartDate' => 'required|date',
    //     'newTasklistEndDate' => 'date',
    //     'newTasklistUrl' => 'nullable|url',
    //     'newTasklistContract' => 'required',
    //     'tasklistPengadaan' => 'required',
    //     'contractSignDate' => 'nullable|date',
    // ];

    protected $listeners = [
        'columnAdded' => 'loadColumns',
        'hapusTasklist' => 'hapusTasklist',
        'deleteTasklistColumnConfirmed' => 'deleteTasklistColumnConfirmed',
    ];

    public function mount()
    {
        $this->loadColumns();
    }

    public function loadColumns()
    {
        $this->columns = Column::with(['tasklists' => function ($query) {
            $query->orderBy('order');
        }])->orderBy('id')->get();
    }

    public function updateTasklistOrder($columnId, $tasklistOrder)
    {
        DB::transaction(function () use ($columnId, $tasklistOrder) {
            foreach ($tasklistOrder as $index => $tasklistId) {
                $order = $index + 1;
                Tasklist::where('id', $tasklistId)->update(['column_id' => $columnId, 'order' => $order, 'status_id' => 1]);
            }
        });

        $this->loadColumns();
    }

    public function openEditColumnModal($column)
    {
        $this->editingColumn = $column['id'];
        $this->tasklistColumnName = $column['name'];
    }

    public function openAddTasklistModal($columnId)
    {
        $this->editingColumn = $columnId;
        $this->dispatch('open-modal', ['modalName' => 'bs-example-modal-lg']);
    }

    public function openEditTasklistModal($tasklist)
    {
        $this->tasklistId = $tasklist['id'];
        $this->editingColumn = $tasklist['column_id'];
        $this->newTasklistName = $tasklist['name'];
        $this->newTasklistCompany = $tasklist['company'];
        $this->location = $tasklist['location'];
        $this->newTasklistValue = $tasklist['value'];
        $this->newTasklistStartDate = $tasklist['started_at'];
        $this->newTasklistEndDate = $tasklist['end_at'];
        $this->newTasklistUrl = $tasklist['url'];
        $this->newTasklistContract = $tasklist['contract_number'];
        $this->tasklistPengadaan = $tasklist['pengadaan'];
        $this->contractSignDate = $tasklist['contract_sign'];
    }

    public function closeEditTasklistModal()
    {
        $this->reset();
        $this->loadColumns();
    }

    public function openAddTaskModal($tasklistColumnId)
    {
        $this->editingTasklistColumn = $tasklistColumnId;
        $this->dispatch('open-modal', ['modalName' => 'add-task-modal']);
    }

    public function updateTasklistColumn()
    {
        $this->validate([
            'tasklistColumnName' => 'required|min:3',
        ]);

        Column::where('id', $this->editingColumn)->update(['name' => $this->tasklistColumnName]);
        $this->reset();
        $this->loadColumns();
        $this->dispatch('close-updateColumnModal', ['modalName' => 'updateColumnModal']);
        $this->alert('success', 'Kolom berhasil diperbarui!');
    }

    public function deleteTasklistColumn($tasklistColumnId)
    {
        $this->tasklistColumnId = $tasklistColumnId;
        $this->alert('warning', 'Apakah anda yakin ingin menghapus kolom ini?', [
            'text' => "Tidak akan ada jalan kembali!",
            'toast' => false,
            'position' => 'center',
            'timer' => false,
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancel',
            'cancelButtonColor' => '#6c757d',
            'confirmButtonColor' => '#dc3545',
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes',
            'reverseButtons' => true,
            'onConfirmed' => 'deleteTasklistColumnConfirmed',
        ]);
    }

    public function deleteTasklistColumnConfirmed()
    {
        Column::where('id', $this->tasklistColumnId)->delete();
        $this->reset();
        $this->loadColumns();
        $this->alert('success', 'Kolom berhasil dihapus!');
    }

    public function addTasklist()
    {
        $this->validate([
            'newTasklistName' => 'required|min:3',
            'newTasklistCompany' => 'required|string',
            'location' => 'nullable|string',
            'newTasklistValue' => 'nullable|numeric',
            'newTasklistStartDate' => 'required',
            'newTasklistEndDate' => 'nullable|date',
            'newTasklistUrl' => 'nullable|url',
            'newTasklistContract' => 'required',
            'tasklistPengadaan' => 'required',
        ]);

        $existingMaxOrder = Tasklist::where('column_id', $this->editingColumn)->max('order');
        $newOrder = $existingMaxOrder ? $existingMaxOrder + 1 : 1;

        $tasklist = Tasklist::create([
            'column_id' => $this->editingColumn,
            'name' => $this->newTasklistName,
            'work_id' => "K-" . rand(10000, 99999),
            'company' => $this->newTasklistCompany,
            'location' => $this->location,
            'value' => $this->newTasklistValue,
            'order' => $newOrder,
            'status_id' => 1,
            'started_at' => $this->newTasklistStartDate,
            'end_at' => $this->newTasklistEndDate ?? null,
            'url' => $this->newTasklistUrl ?? null,
            'contract_number' => $this->newTasklistContract,
            'pengadaan' => $this->tasklistPengadaan,
        ]);

        $defaultColumns = ['Upcoming', 'In Progress', 'Completed'];
        foreach ($defaultColumns as $index => $columnName) {
            TasklistColumn::create([
                'tasklist_id' => $tasklist->id,
                'name' => $columnName,
                'order' => $index + 1,
            ]);
        }

        $this->reset(['newTasklistName', 'newTasklistCompany', 'location', 'newTasklistValue', 'editingColumn', 'newTasklistStartDate', 'newTasklistEndDate', 'newTasklistUrl', 'newTasklistContract', 'tasklistPengadaan']);
        $this->loadColumns();
        $this->dispatch('close-modal', ['modalName' => 'bs-example-modal-lg']);
        $this->alert('success', 'Tasklist berhasil ditambahkan!');
    }

    public function updateTasklist()
    {
        $this->validate([
            'newTasklistName' => 'required|min:3',
            'newTasklistCompany' => 'required|string',
            'location' => 'nullable|string',
            'newTasklistValue' => 'nullable|numeric',
            'newTasklistStartDate' => 'required',
            'newTasklistEndDate' => 'nullable|date',
            'newTasklistUrl' => 'nullable|url',
            'newTasklistContract' => 'required',
            'tasklistPengadaan' => 'required',
            'contractSignDate' => 'nullable|date',
        ]);

        $data = [
            'name' => $this->newTasklistName,
            'company' => $this->newTasklistCompany,
            'location' => $this->location,
            'value' => $this->newTasklistValue,
            'started_at' => $this->newTasklistStartDate,
            'end_at' => $this->newTasklistEndDate ?? null,
            'url' => $this->newTasklistUrl ?? null,
            'contract_number' => $this->newTasklistContract,
            'pengadaan' => $this->tasklistPengadaan,
            'contract_sign' => $this->contractSignDate ?? null,
        ];

        Tasklist::where('id', $this->tasklistId)->update($data);
        $this->reset();
        $this->loadColumns();
        $this->dispatch('close-updateModal', ['modalName' => 'updateModal']);
        $this->alert('success', 'Tasklist berhasil diperbarui!');
    }

    public function deleteTasklist($tasklistId)
    {
        $this->tasklistId = $tasklistId;
        $this->alert('warning', 'Apakah anda yakin?', [
            'text' => "Tidak akan ada jalan kembali!",
            'toast' => false,
            'position' => 'center',
            'timer' => false,
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancel',
            'cancelButtonColor' => '#6c757d',
            'confirmButtonColor' => '#dc3545',
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes',
            'reverseButtons' => true,
            'onConfirmed' => 'hapusTasklist',
        ]);
    }

    public function hapusTasklist()
    {
        $tasklist = Tasklist::where('id', $this->tasklistId);
        $tasklist->delete();
        $this->loadColumns();
        $this->alert('success', 'Tasklist berhasil dihapus!');
    }

    public function addTask()
    {
        $this->validate([
            'newTaskName' => 'required|min:3',
        ]);

        Task::create([
            'tasklist_column_id' => $this->editingTasklistColumn,
            'name' => $this->newTaskName,
            'order' => Task::where('tasklist_column_id', $this->editingTasklistColumn)->max('order') + 1,
        ]);

        $this->reset(['newTaskName', 'editingTasklistColumn']);
        $this->loadCurrentTasklist();
        $this->dispatch('close-modal', ['modalName' => 'add-task-modal']);
    }

    private function loadCurrentTasklist()
    {
        if ($this->currentTasklist) {
            $this->currentTasklist = Tasklist::with(['tasklistColumns.tasks' => function ($query) {
                $query->orderBy('order');
            }])->findOrFail($this->currentTasklist->id);
        }
    }

    public function render()
    {
        return view('livewire.kanban');
    }
}
