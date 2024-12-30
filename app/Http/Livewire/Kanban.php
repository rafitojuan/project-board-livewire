<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Column;
use App\Models\Tasklist;
use App\Models\TasklistColumn;
use App\Models\Task;
use App\Models\Team;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

#[Title('Glide | Project')]

class Kanban extends Component
{
    use LivewireAlert, WithPagination;

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
    public $userId;

    public $teamData;
    public $teamId;
    public $logs;

    protected $listeners = [
        'columnAdded' => 'loadColumns',
        'hapusTasklist' => 'hapusTasklist',
        'deleteTasklistColumnConfirmed' => 'deleteTasklistColumnConfirmed',
    ];

    public function mount(string $id): void
    {
        $decryptedId = Crypt::decryptString($id);
        $this->teamData = Team::with(['teamAccess' => function ($query) {
            $query->select('id', 'team_id', 'user_id', 'role_team');
        }])->findOrFail($decryptedId);
        $this->teamId = $decryptedId;

        $this->loadColumns($this->teamId);
    }

    public function loadColumns($id): void
    {
        $this->columns = Column::with(['tasklists' => function ($query) use ($id) {
            $query->where('team_id', $id)->orderBy('order');
        }])->orderBy('id')->get();
    }

    // public function updateTasklistOrder($columnId, $tasklistOrder)
    // {
    //     DB::transaction(function () use ($columnId, $tasklistOrder) {
    //         foreach ($tasklistOrder as $index => $tasklistId) {
    //             $order = $index + 1;
    //             Tasklist::where('id', $tasklistId)->update(['column_id' => $columnId, 'order' => $order]);
    //             activity()->log('Project dipindahkan cuk');
    //         }
    //     });

    //     $this->loadColumns();
    // }

    public function updateTasklistOrder(int $columnId, array $tasklistOrder, $id): void
    {
        try {
            $tasklistOrder = array_values(array_filter($tasklistOrder, function ($id) {
                return !is_null($id) && $id !== '';
            }));

            $tasklistOrder = array_map('intval', $tasklistOrder);

            if (empty($tasklistOrder)) {
                throw new \InvalidArgumentException("No valid tasklist IDs provided");
            }

            DB::transaction(function () use ($columnId, $tasklistOrder) {
                $existingTasklists = Tasklist::whereIn('id', $tasklistOrder)->pluck('id')->toArray();
                $missingTasklists = array_diff($tasklistOrder, $existingTasklists);

                if (!empty($missingTasklists)) {
                    throw new ModelNotFoundException("Could not find tasklist(s): " . implode(', ', $missingTasklists));
                }

                foreach ($tasklistOrder as $index => $tasklistId) {
                    $order = $index + 1;

                    $tasklist = Tasklist::findOrFail($tasklistId);
                    $oldColumn = Column::findOrFail($tasklist->column_id);
                    $newColumn = Column::findOrFail($columnId);

                    $tasklist->column_id = $columnId;
                    $tasklist->order = $order;
                    $tasklist->save();

                    activity()
                        ->performedOn($tasklist)
                        ->withProperties([
                            'tasklist_name' => $tasklist->name,
                            'old_column' => $oldColumn->name,
                            'new_column' => $newColumn->name,
                            'new_order' => $order
                        ])
                        ->log("Projek '{$tasklist->name}' dipindahkan dari {$oldColumn->name} ke {$newColumn->name}");
                }
            });

            $this->loadColumns($id);
        } catch (\Exception $e) {
            Log::error("Error in updateTasklistOrder: " . $e->getMessage(), [
                'columnId' => $columnId,
                'original_tasklistOrder' => $tasklistOrder,
                'filtered_tasklistOrder' => array_filter($tasklistOrder)
            ]);
            throw $e;
        }
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
        // $this->reset();
        $this->loadColumns($this->teamId);
    }

    public function openAddTaskModal($tasklistColumnId)
    {
        $this->editingTasklistColumn = $tasklistColumnId;
        $this->dispatch('open-modal', ['modalName' => 'add-task-modal']);
    }

    public function updateTasklistColumn($id)
    {
        $this->validate([
            'tasklistColumnName' => 'required|min:3',
        ]);

        Column::where('id', $this->editingColumn)->update(['name' => $this->tasklistColumnName]);
        $this->reset();
        $this->loadColumns($id);
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

    public function deleteTasklistColumnConfirmed($id)
    {
        Column::where('id', $this->tasklistColumnId)->delete();
        $this->reset();
        $this->loadColumns($id);
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
            'newTasklistEndDate' => 'nullable|date|after:newTasklistStartDate',
            'newTasklistUrl' => 'nullable|url',
            'newTasklistContract' => 'required',
            'tasklistPengadaan' => 'required',
        ], [
            'newTasklistName.required' => 'Nama tidak boleh kosong!',
            'newTasklistName.min' => 'Nama minimal 3 karakter!',
            'newTasklistCompany.required' => 'Perusahaan tidak boleh kosong!',
            'newTasklistStartDate.required' => 'Tanggal mulai tidak boleh kosong!',
            'newTasklistContract.required' => 'Nomor kontrak tidak boleh kosong!',
            'tasklistPengadaan.required' => 'Pengadaan tidak boleh kosong!',
            'newTasklistEndDate.date' => 'Tanggal selesai harus berupa tanggal!',
            'newTasklistEndDate.after' => 'Tanggal selesai harus setelah tanggal mulai!',
            'newTasklistUrl.url' => 'URL tidak valid!',
            'newTasklistValue.numeric' => 'Nilai harus berupa angka!',
        ]);

        $existingMaxOrder = Tasklist::where('column_id', $this->editingColumn)->max('order');
        $newOrder = $existingMaxOrder ? $existingMaxOrder + 1 : 1;

        $tasklist = Tasklist::create([
            'column_id' => $this->editingColumn,
            'name' => trim($this->newTasklistName),
            'work_id' => "K-" . rand(10000, 99999),
            'company' => trim($this->newTasklistCompany),
            'location' => $this->location ? trim($this->location) : null,
            'value' => $this->newTasklistValue,
            'order' => $newOrder,
            'status_id' => 1,
            'started_at' => $this->newTasklistStartDate,
            'end_at' => $this->newTasklistEndDate ?? null,
            'url' => $this->newTasklistUrl ? trim($this->newTasklistUrl) : null,
            'contract_number' => trim($this->newTasklistContract),
            'pengadaan' => trim($this->tasklistPengadaan),
            'color' => Auth::user()->role->color,
            'user_id' => Auth::user()->id,
            'team_id' => $this->teamId,
        ]);

        $defaultColumns = ['Potential', 'In Progress', 'Completed'];
        foreach ($defaultColumns as $index => $columnName) {
            TasklistColumn::create([
                'tasklist_id' => $tasklist->id,
                'name' => $columnName,
                'order' => $index + 1,
            ]);
        }

        $this->reset(['newTasklistName', 'newTasklistCompany', 'location', 'newTasklistValue', 'editingColumn', 'newTasklistStartDate', 'newTasklistEndDate', 'newTasklistUrl', 'newTasklistContract', 'tasklistPengadaan']);
        $this->loadColumns($this->teamId);
        $this->dispatch('close-modal', ['modalName' => 'bs-example-modal-lg']);
        $this->alert('success', 'Tasklist berhasil ditambahkan!');
    }

    public function updateTasklist($id)
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
            'color' => Auth::user()->role->color,
            'user_id' => Auth::user()->role->id > 2 ? Auth::user()->id : Auth::user()->id
        ];

        $tasklist = Tasklist::find($this->tasklistId);

        $changes = array_diff_assoc($data, $tasklist->toArray());
        $changeLog = [];
        foreach ($changes as $field => $value) {
            $changeLog[] = "Kolom ($field) di project " . $tasklist->name . " telah diperbarui";
        }

        activity()
            ->performedOn($tasklist)
            ->causedBy(Auth::user())
            ->withProperties([
                'old' => $tasklist->toArray(),
                'new' => $data
            ])
            ->log(implode(', ', $changeLog));

        $tasklist->update($data);
        $this->reset();
        $this->loadColumns($id);
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

    public function hapusTasklist($id)
    {
        $tasklist = Tasklist::where('id', $this->tasklistId)->first();

        activity()
            ->performedOn($tasklist)
            ->causedBy(Auth::user())
            ->withProperties([
                'deleted' => $tasklist->toArray()
            ])
            ->log("Project {$tasklist->name} dihapus");

        $tasklist->delete();
        $this->loadColumns($id);
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

    public function allLogs()
    {
        $this->logs = Activity::where('subject_type', Tasklist::class)
            ->latest()
            ->get();

        return view('livewire.log', [
            'logs' => $this->logs
        ]);
    }

    public function render()
    {
        $tasklists = DB::table('v_tasklists_rekap')
            ->get();
        return view('livewire.kanban', [
            'detilTasklist' => $tasklists,
            'team' => $this->teamData,
        ]);
    }
}
