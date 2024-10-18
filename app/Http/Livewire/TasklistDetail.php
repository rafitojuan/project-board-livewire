<?php

namespace App\Http\Livewire;

use App\Models\Subtask;
use App\Models\Tasklist;
use App\Models\TasklistColumn;
use App\Models\Task;
use Livewire\Component;
use Illuminate\Support\Facades\Crypt;
use Livewire\Attributes\Title;
use Jantinnerezo\LivewireAlert\LivewireAlert;

#[Title('Tasklist Detail')]
class TasklistDetail extends Component
{
    use LivewireAlert;

    public $tasklist;
    public $tasklistColumns;
    public $newColumnName;
    public $editingColumnId;
    public $editingColumnName;
    public $newTaskName;
    public $editingTasklistColumnId;
    public $editingTaskId;
    public $editingTaskName;
    public $taskId;
    public $editingTaskColumn;
    public $taskName;
    public $taskStartDate;
    public $taskEndDate;
    public $tasklistColumnName;
    public $subtaskName;
    public $subtaskJob;
    public $subtaskValue;
    public $subTaskStarted;
    public $subTaskEnd;
    public $subtaskId;
    public $subtaskCompleted;
    public $subTaskKeterangan;
    public $taskUrl;
    public $subtaskUrl;
    public $kode;

    protected $rules = [
        'newColumnName' => 'required|min:3',
        'taskName' => 'required|min:3',
        'taskStartDate' => 'required|date',
        'taskEndDate' => 'date',
        'subtaskName' => 'required|min:3',
        'subtaskJob' => 'required|min:3',
        'subtaskValue' => 'min:3|numeric',
        'subTaskStarted' => 'required|date',
        'subTaskEnd' => 'date',
        'subtaskCompleted' => 'boolean',
        'subTaskKeterangan' => 'nullable|string',
        'taskUrl' => 'nullable|url',
        'subtaskUrl' => 'nullable|url',
    ];

    protected $listeners = [
        'refreshTasklistColumns' => '$refresh',
        'deleteColumnConfirmed' => 'deleteColumnConfirmed',
        'hapusTask' => 'hapusTask',
        'deleteTasklistColumnConfirmed' => 'deleteColumn',
        'editSubtask' => 'editSubtask',
    ];

    public function mount($encryptedId)
    {
        try {
            $id = Crypt::decryptString($encryptedId);
            $this->tasklist = Tasklist::find($id);
            $this->loadTasklistColumns();
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function loadTasklistColumns()
    {
        $this->tasklistColumns = $this->tasklist->tasklistColumns()->with(['tasks' => function ($query) {
            $query->orderBy('order');
        }])->orderBy('id')->get();
    }

    public function updateTaskOrder($columnId, $taskOrder)
    {
        foreach ($taskOrder as $index => $taskId) {
            Task::where('id', $taskId)->update(['tasklist_column_id' => $columnId, 'order' => $index + 1]);
        }

        $this->loadTasklistColumns();
    }

    public function openTaskModal($editingTaskId)
    {
        $this->editingTasklistColumnId = $editingTaskId;
        $this->dispatch('open-taskModal', ['modalName' => 'addTaskModal']);
    }

    public function addTask()
    {
        $this->validate([
            'taskName' => 'required|min:3',
            'taskStartDate' => 'required|date',
            'taskEndDate' => 'date',
            'taskUrl' => 'nullable|url',
        ]);

        Task::create([
            'tasklist_column_id' => $this->editingTasklistColumnId,
            'name' => $this->taskName,
            'started_at' => $this->taskStartDate,
            'end_at' => $this->taskEndDate,
            'order' => Task::where('tasklist_column_id', $this->editingTasklistColumnId)->max('order') + 1,
            'status_id' => 1,
            'url' => $this->taskUrl,
        ]);

        $this->reset('taskName', 'taskStartDate', 'taskEndDate', 'taskUrl');
        $this->dispatch('close-taskModal', ['modalName' => 'closeTaskModal']);
        $this->loadTasklistColumns();
        $this->alert('success', 'Task added successfully!');
    }

    public function openEditTaskModal($task)
    {
        $this->taskId = $task['id'];
        $this->editingTasklistColumnId = $task['tasklist_column_id'];
        $this->taskName = $task['name'];
        $this->taskStartDate = $task['started_at'];
        $this->taskEndDate = $task['end_at'];
        $this->taskUrl = $task['url'];
    }

    public function closeTaskModal()
    {
        $this->reset('taskName', 'taskStartDate', 'taskEndDate', 'taskUrl');
    }

    public function updateTask()
    {
        $this->validate([
            'taskName' => 'required|min:3',
            'taskStartDate' => 'required',
            'taskEndDate' => 'date',
            'taskUrl' => 'nullable|url',
        ]);

        Task::where('id', $this->taskId)->update([
            'name' => $this->taskName,
            'started_at' => $this->taskStartDate,
            'end_at' => $this->taskEndDate,
            'url' => $this->taskUrl,
        ]);

        $this->reset('taskName', 'taskStartDate', 'taskEndDate', 'taskUrl');
        $this->dispatch('close-taskModal', ['modalName' => 'updateTaskModal']);
        $this->loadTasklistColumns();
        $this->alert('success', 'Task updated successfully!');
    }

    public function deleteTask($taskId)
    {
        $this->taskId = $taskId;
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
            'onConfirmed' => 'hapusTask',
        ]);
    }

    public function hapusTask()
    {
        Task::where('id', $this->taskId)->delete();
        $this->reset('taskId', 'taskName', 'taskStartDate');
        $this->loadTasklistColumns();
        $this->alert('success', 'Task berhasil dihapus!');
    }

    public function openEditTasklistColumnModal($tasklist)
    {
        $this->editingTasklistColumnId = $tasklist['id'];
        $this->tasklistColumnName = $tasklist['name'];
    }

    public function addTasklistColumn(): void
    {
        $this->validate([
            'tasklistColumnName' => 'required|min:3',
        ]);

        TasklistColumn::create([
            'name' => $this->tasklistColumnName,
            'tasklist_id' => $this->tasklist->id,
            'order' => TasklistColumn::where('tasklist_id', $this->tasklist->id)->max('order') + 1,
        ]);

        $this->reset('tasklistColumnName');
        $this->loadTasklistColumns();
        $this->dispatch('close-taskModal', ['modalName' => 'addColumnModal']);
        $this->alert('success', 'Kolom berhasil ditambahkan!');
    }

    public function updateTasklistColumn()
    {
        $this->validate([
            'tasklistColumnName' => 'required|min:3',
        ]);

        TasklistColumn::where('id', $this->editingTasklistColumnId)->update(['name' => $this->tasklistColumnName]);
        $this->reset('tasklistColumnName');
        $this->loadTasklistColumns();
        $this->dispatch('close-taskModal', ['modalName' => 'updateTasklistColumnModal']);
        $this->alert('success', 'Kolom berhasil diperbarui!');
    }

    public function deleteTasklistColumn($tasklist)
    {
        $this->editingTasklistColumnId = $tasklist;
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
            'onConfirmed' => 'deleteTasklistColumnConfirmed',
        ]);
    }

    public function deleteColumn()
    {
        TasklistColumn::where('id', $this->editingTasklistColumnId)->delete();
        $this->reset('tasklistColumnName');
        $this->loadTasklistColumns();
        $this->alert('success', 'Kolom berhasil dihapus!');
    }

    public function openSubTaskModal($task)
    {
        $this->kode = $task['id'];
        // dd($this->kode);
    }

    public function closeSubtaskModal($kode)
    {
        // $this->reset($kode);
        $this->kode = null;
    }

    public function addSubtask()
    {
        $this->validate([
            'subtaskName' => 'required|min:3',
            'subtaskJob' => 'required|min:3',
            'subtaskValue' => 'numeric',
            'subTaskStarted' => 'required|date',
            'subTaskEnd' => 'date',
            'subtaskUrl' => 'nullable|url',
        ]);

        Subtask::create([
            'name' => $this->subtaskName,
            'pelaksana' => $this->subtaskJob,
            'biaya' => $this->subtaskValue,
            'started_at' => $this->subTaskStarted,
            'end_at' => $this->subTaskEnd,
            'task_id' => $this->taskId,
            'keterangan' => 'order',
            'url' => $this->subtaskUrl,
        ]);

        $this->reset('subtaskName', 'subtaskJob', 'subtaskValue', 'subTaskStarted', 'subTaskEnd', 'subtaskUrl');
        $this->alert('success', 'Subtask berhasil ditambahkan!');
        $this->dispatch('refreshDatatable');
    }

    public function editSubtask($data)
    {
        $this->subtaskName = $data['subtaskName'];
        $this->subtaskId = $data['subtaskId'];
        $this->subtaskJob = $data['subtaskJob'];
        $this->subtaskValue = $data['subtaskValue'];
        $this->subTaskStarted = $data['subTaskStarted'];
        $this->subTaskEnd = $data['subTaskEnd'];
        $this->subtaskCompleted = $data['subtaskCompleted'];
        $this->subTaskKeterangan = $data['subTaskKeterangan'];
        $this->subtaskUrl = $data['subtaskUrl'];
    }

    public function updateSubtask()
    {
        $this->validate([
            'subtaskName' => 'required|min:3',
            'subtaskJob' => 'required|min:3',
            'subtaskValue' => 'numeric',
            'subTaskStarted' => 'required|date',
            'subTaskEnd' => 'date',
            'subtaskCompleted' => 'required|boolean',
            'subTaskKeterangan' => 'required',
            'subtaskUrl' => 'nullable|url',
        ]);
        Subtask::where('id', $this->subtaskId)->update([
            'name' => $this->subtaskName,
            'pelaksana' => $this->subtaskJob,
            'biaya' => $this->subtaskValue,
            'started_at' => $this->subTaskStarted,
            'end_at' => $this->subTaskEnd,
            'keterangan' => $this->subTaskKeterangan,
            'completed' => $this->subtaskCompleted,
            'url' => $this->subtaskUrl,
        ]);
        $this->reset('subtaskName', 'subtaskJob', 'subtaskValue', 'subTaskStarted', 'subTaskEnd', 'subtaskCompleted', 'subTaskKeterangan', 'subtaskUrl');
        $this->dispatch('close-taskModal', ['modalName' => 'editSubtaskModal']);
        $this->dispatch('open-subtaskModal', ['modalName' => 'subTaskModal']);
        $this->alert('success', 'Subtask berhasil diperbarui!');
        $this->dispatch('refreshDatatable');
    }

    public function closeSubtaskAddModal()
    {
        $this->reset('subtaskName', 'subtaskJob', 'subtaskValue', 'subTaskStarted', 'subTaskEnd', 'subtaskCompleted', 'subTaskKeterangan', 'subtaskUrl');
    }

    public function render()
    {
        return view('livewire.tasklist-detail');
    }
}
