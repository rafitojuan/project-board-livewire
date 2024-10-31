<?php

namespace App\Http\Livewire;

use App\Models\Status;
use App\Models\Subtask;
use App\Models\Tasklist;
use App\Models\TasklistColumn;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
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
    public $tasklistStatus = 1;
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
    public $uraian;
    public $statusColor;
    public $newTasklistStartDate;
    public $taskValue;
    public $taskSubtotals = [];

    protected $listeners = [
        'refreshTasklistColumns' => '$refresh',
        'deleteColumnConfirmed' => 'deleteColumnConfirmed',
        'hapusTask' => 'hapusTask',
        'deleteTasklistColumnConfirmed' => 'deleteColumn',
        'editSubtask' => 'editSubtask',
        'subtotal-updated' => 'handleSubtotalUpdate'
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
            'taskStartDate' => ['required', 'date', 'after_or_equal:' . $this->tasklist->started_at, 'before_or_equal:' . $this->tasklist->end_at],
            'taskEndDate' => ['date', 'before_or_equal:' . $this->tasklist->end_at, 'after_or_equal:' . $this->tasklist->started_at],
            'taskUrl' => 'nullable|url',
            'taskValue' => 'nullable|numeric',
        ], [
            'taskStartDate.after_or_equal' => 'Mulai kontrak harus setelah tanggal mulai project.',
            'taskStartDate.before_or_equal' => 'Mulai kontrak melewati tanggal akhir project.',
            'taskEndDate.before_or_equal' => 'Akhir kontrak harus sebelum tanggal akhir project.',
            'taskEndDate.after_or_equal' => 'Akhir kontrak tidak boleh mendahului.',
            'taskUrl.url' => 'Link harus valid.',
            'taskValue.numeric' => 'Nilai harus berupa angka.',
        ]);

        Task::create([
            'tasklist_column_id' => $this->editingTasklistColumnId,
            'name' => $this->taskName,
            'started_at' => $this->taskStartDate,
            'end_at' => $this->taskEndDate,
            'order' => Task::where('tasklist_column_id', $this->editingTasklistColumnId)->max('order') + 1,
            'status_id' => 1,
            'user_id' => Auth::user()->id,
            'url' => $this->taskUrl,
            'value' => $this->taskValue,
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
        $this->taskValue = $task['value'];
    }

    public function closeTaskModal()
    {
        $this->reset('taskName', 'taskStartDate', 'taskEndDate', 'taskUrl');
    }

    public function updateTask()
    {
        $this->validate([
            'taskName' => 'required|min:3',
            'taskStartDate' => ['required', 'date', 'after_or_equal:' . $this->tasklist->started_at, 'before_or_equal:' . $this->tasklist->end_at],
            'taskEndDate' => ['date', 'before_or_equal:' . $this->tasklist->end_at, 'after_or_equal:' . $this->tasklist->started_at],
            'taskUrl' => 'nullable|url',
        ], [
            'taskStartDate.after_or_equal' => 'Mulai kontrak harus setelah tanggal mulai project.',
            'taskStartDate.before_or_equal' => 'Mulai kontrak melewati tanggal akhir project.',
            'taskEndDate.before_or_equal' => 'Akhir kontrak harus sebelum tanggal akhir project.',
            'taskEndDate.after_or_equal' => 'Akhir kontrak tidak boleh mendahului.',
            'taskUrl.url' => 'Link harus valid.',
        ]);

        Task::where('id', $this->taskId)->update([
            'name' => $this->taskName,
            'started_at' => $this->taskStartDate,
            'end_at' => $this->taskEndDate,
            'url' => $this->taskUrl,
            'value' => $this->taskValue,
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
        $this->uraian = $task['name'];
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
            'subTaskStarted' => ['required', 'date', 'after_or_equal:' . Task::find($this->kode)->started_at, 'before:' . Task::find($this->kode)->end_at],
            'subTaskEnd' => ['date', 'before_or_equal:' . Task::find($this->kode)->end_at, 'after_or_equal:' . Task::find($this->kode)->started_at],
            'subTaskKeterangan' => 'nullable|min:3',
            'subtaskUrl' => 'nullable|url',
        ], [
            'subtaskName.required' => 'Nama harus diisi.',
            'subtaskName.min' => 'Nama detail pekerjaan minimal 3 karakter.',
            'subtaskJob.required' => 'Pelaksana harus diisi.',
            'subtaskJob.min' => 'Pelaksana minimal 3 karakter.',
            'subtaskValue.numeric' => 'Biaya harus berupa angka.',
            'subTaskStarted.required' => 'Tanggal mulai harus diisi.',
            'subTaskStarted.date' => 'Tanggal mulai harus berupa tanggal.',
            'subTaskEnd.date' => 'Tanggal selesai harus berupa tanggal.',
            'subtaskUrl.url' => 'URL subtask harus berupa URL yang valid.',
            'subTaskKeterangan.min' => 'Keterangan subtask minimal 3 karakter.',
            'subTaskStarted.after_or_equal' => 'Tanggal mulai harus setelah atau sama dengan tanggal mulai pekerjaan.',
            'subTaskEnd.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai pekerjaan.',
            'subTaskEnd.before_or_equal' => 'Tanggal selesai harus sebelum atau sama dengan tanggal akhir pekerjaan.',
        ]);

        Subtask::create([
            'name' => $this->subtaskName,
            'pelaksana' => $this->subtaskJob,
            'biaya' => $this->subtaskValue,
            'started_at' => $this->subTaskStarted,
            'end_at' => $this->subTaskEnd,
            'task_id' => $this->kode,
            'keterangan' => $this->subTaskKeterangan,
            'url' => $this->subtaskUrl,
        ]);

        $this->reset('subtaskName', 'subtaskJob', 'subtaskValue', 'subTaskStarted', 'subTaskEnd', 'subtaskUrl', 'subTaskKeterangan');
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
            'subTaskStarted' => ['required', 'date', 'after_or_equal:' . Task::find($this->kode)->started_at, 'before:' . Task::find($this->kode)->end_at],
            'subTaskEnd' => ['date', 'before_or_equal:' . Task::find($this->kode)->end_at, 'after_or_equal:' . Task::find($this->kode)->started_at],
            'subTaskKeterangan' => 'nullable|min:3',
            'subtaskUrl' => 'nullable|url',
        ], [
            'subtaskName.required' => 'Nama harus diisi.',
            'subtaskName.min' => 'Nama detail pekerjaan minimal 3 karakter.',
            'subtaskJob.required' => 'Pelaksana harus diisi.',
            'subtaskJob.min' => 'Pelaksana minimal 3 karakter.',
            'subtaskValue.numeric' => 'Biaya harus berupa angka.',
            'subTaskStarted.required' => 'Tanggal mulai harus diisi.',
            'subTaskStarted.date' => 'Tanggal mulai harus berupa tanggal.',
            'subTaskEnd.date' => 'Tanggal selesai harus berupa tanggal.',
            'subtaskUrl.url' => 'URL subtask harus berupa URL yang valid.',
            'subTaskKeterangan.min' => 'Keterangan subtask minimal 3 karakter.',
            'subTaskStarted.after_or_equal' => 'Tanggal mulai harus setelah atau sama dengan tanggal mulai pekerjaan.',
            'subTaskEnd.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai pekerjaan.',
            'subTaskEnd.before_or_equal' => 'Tanggal selesai harus sebelum atau sama dengan tanggal akhir pekerjaan.',
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

    public function saveTasklistStatus()
    {
        $this->validate([
            'tasklistStatus' => 'required',
        ]);
        $tasklist = Tasklist::find($this->tasklist->id);
        $tasklist->status_id = $this->tasklistStatus;
        $tasklist->save();
        $this->tasklist->refresh();
        return $this->tasklist->status->color;
        $this->alert('success', 'Status berhasil diperbarui!');
    }

    public function getSubtotal($taskId)
    {
        return Subtask::where('task_id', $taskId)->sum('biaya');
    }


    public function render()
    {
        $statuses = Status::all();
        return view('livewire.tasklist-detail', compact('statuses'));
    }
}
