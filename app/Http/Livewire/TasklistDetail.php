<?php

namespace App\Http\Livewire;

use App\Models\Status;
use App\Models\Subtask;
use App\Models\Tasklist;
use App\Models\TasklistColumn;
use App\Models\Task;
use App\Models\User;
use App\Notifications\ApproveNotification;
use App\Notifications\TugasNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Title;
use Jantinnerezo\LivewireAlert\LivewireAlert;

#[Title('Glide | Detail Projek')]
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
    public $subtaskRAB;
    public $subtaskRAP;
    public $subtaskRAPP;
    public $subTaskStarted;
    public $subTaskEnd;
    public $subtaskId;
    public $subtaskCompleted;
    public $subTaskStatus;
    public $subTaskKeterangan;
    public $taskUrl;
    public $subtaskUrl;
    public $kode;
    public $uraian;
    public $statusColor;
    public $newTasklistStartDate;
    public $taskValue;
    public $taskSubtotals = [];
    public $userList;
    public $subtaskSAP;
    public $idJadwalTask;
    public $namaAcaraTask;
    public $tanggalMulaiTask;
    public $tanggalSelesaiTask;
    public $statusJadwalTask;


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
        $this->userList();
    }

    public function userList()
    {
        // $this->userList = DB::table('users')
        //     ->select('id', 'name')
        //     ->where('id', '!=', Auth::id())
        //     ->get();

        $this->userList = User::all();
        return $this->userList;
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
            'subtaskJob' => 'required',
            'subtaskRAB' => ['numeric', 'lte:' . $this->getSelisihBiaya()['rawValue']],
            'subTaskStarted' => ['required', 'date', 'after_or_equal:' . Task::find($this->kode)->started_at, 'before_or_equal:' . Task::find($this->kode)->end_at],
            'subTaskEnd' => ['date', 'after_or_equal:' . Task::find($this->kode)->started_at, 'before_or_equal:' . Task::find($this->kode)->end_at],
            'subTaskKeterangan' => 'nullable|min:3',
            'subtaskUrl' => 'nullable|url',
        ], [
            'subtaskName.required' => 'Nama harus diisi.',
            'subtaskName.min' => 'Nama detail pekerjaan minimal 3 karakter.',
            'subtaskJob.required' => 'Pelaksana harus diisi.',
            'subtaskRAB.numeric' => 'RAB harus berupa angka.',
            'subtaskRAB.lte' => 'RAB tidak boleh lebih besar dari Nilai Project (tersedia: Rp.' . $this->getSelisihBiaya()['value'] . ').',
            'subTaskStarted.required' => 'Tanggal mulai harus diisi.',
            'subTaskStarted.date' => 'Tanggal mulai harus berupa tanggal.',
            'subTaskEnd.date' => 'Tanggal selesai harus berupa tanggal.',
            'subtaskUrl.url' => 'URL harus valid.',
            'subTaskKeterangan.min' => 'Keterangan subtask minimal 3 karakter.',
            'subTaskStarted.before_or_equal' => 'Tanggal mulai harus setelah tanggal projek.',
            'subTaskStarted.after_or_equal' => 'Tanggal mulai harus setelah atau sama dengan tanggal mulai pekerjaan.',
            'subTaskEnd.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai pekerjaan.',
            'subTaskEnd.before_or_equal' => 'Tanggal selesai harus sebelum atau sama dengan tanggal akhir pekerjaan.',
        ]);

        Subtask::create([
            'name' => $this->subtaskName,
            'pelaksana' => $this->subtaskJob,
            'sap' => $this->subtaskSAP ?? false,
            'rab' => $this->subtaskRAB,
            'started_at' => $this->subTaskStarted,
            'end_at' => $this->subTaskEnd,
            'task_id' => $this->kode,
            'keterangan' => $this->subTaskKeterangan,
            'url' => $this->subtaskUrl,
            'status_id' => 1
        ]);

        $this->notifTugas();
        $this->reset([
            'subtaskName',
            'subtaskJob',
            'subtaskValue',
            'subTaskStarted',
            'subTaskEnd',
            'subtaskUrl',
            'subTaskKeterangan',
            'subTaskStatus',
            'subtaskSAP',
            'subtaskRAB',
            'subtaskRAP',
            'subtaskRAPP'
        ]);
        $this->alert('success', 'Subtask berhasil ditambahkan!');
        $this->dispatch('refreshDatatable');
    }

    public function notifTugas()
    {
        $user = User::find($this->subtaskJob);

        if ($user) {
            $pelaksana = $user;
            Notification::send($user, new TugasNotification($pelaksana));
        }
    }

    public function editSubtask($data)
    {
        $this->subtaskName = $data['subtaskName'];
        $this->subtaskId = $data['subtaskId'];
        $this->subtaskJob = $data['subtaskJob'];
        $this->subTaskStatus = $data['subTaskStatus'];
        $this->subtaskValue = $data['subtaskValue'];
        $this->subtaskRAB = $data['subtaskRAB'];
        $this->subtaskRAP = $data['subtaskRAP'];
        $this->subtaskRAPP = $data['subtaskRAPP'];
        $this->subTaskStarted = $data['subTaskStarted'];
        $this->subTaskEnd = $data['subTaskEnd'];
        $this->subtaskCompleted = $data['subtaskCompleted'];
        $this->subTaskKeterangan = $data['subTaskKeterangan'];
        $this->subtaskUrl = $data['subtaskUrl'];
        $this->subtaskSAP = $data['subtaskSAP'];
    }

    public function getSelisihBiaya()
    {
        $totalBiaya = $this->getTotalBiaya() ?? 0;
        $tasklistValue = $this->tasklist->value ?? 0;
        $selisih = $tasklistValue - $totalBiaya;
        $textClass = $totalBiaya > $tasklistValue ? 'text-danger' : ($totalBiaya < $tasklistValue ? 'text-success' : 'text-dark');

        return [
            'class' => $textClass,
            'prefix' => $selisih < 0 ? '- Rp' : 'Rp',
            'rawValue' => $selisih,
            'value' => number_format(abs($selisih), 0, ',', '.')
        ];
    }

    public function updateSubtask()
    {
        $this->validate([
            'subtaskName' => 'required|min:3',
            'subtaskJob' => 'required',
            'subtaskRAB' => ['numeric', 'lte:' . $this->getSelisihBiaya()['rawValue']],
            'subTaskStarted' => ['required', 'date', 'after_or_equal:' . Task::find($this->kode)->started_at, 'before_or_equal:' . Task::find($this->kode)->end_at],
            'subTaskEnd' => ['date', 'before_or_equal:' . Task::find($this->kode)->end_at, 'after_or_equal:' . Task::find($this->kode)->started_at],
            'subTaskKeterangan' => 'nullable|min:3',
            'subtaskUrl' => 'nullable|url',
        ], [
            'subtaskName.required' => 'Nama harus diisi.',
            'subtaskName.min' => 'Nama detail pekerjaan minimal 3 karakter.',
            'subtaskJob.required' => 'Pelaksana harus diisi.',
            'subtaskRAB.numeric' => 'RAB harus berupa angka.',
            'subtaskRAB.lte' => 'RAB tidak boleh lebih besar dari Nilai Project (tersedia: Rp.' . $this->getSelisihBiaya()['value'] . ').',
            'subTaskStarted.required' => 'Tanggal mulai harus diisi.',
            'subTaskStarted.date' => 'Tanggal mulai harus berupa tanggal.',
            'subTaskEnd.date' => 'Tanggal selesai harus berupa tanggal.',
            'subtaskUrl.url' => 'URL subtask harus berupa URL yang valid.',
            'subTaskKeterangan.min' => 'Keterangan subtask minimal 3 karakter.',
            'subTaskStarted.after_or_equal' => 'Tanggal mulai harus setelah atau sama dengan tanggal mulai pekerjaan.',
            'subTaskStarted.before_or_equal' => 'Tanggal mulai harus setelah atau sama dengan tanggal mulai pekerjaan.',
            'subTaskEnd.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai pekerjaan.',
            'subTaskEnd.before_or_equal' => 'Tanggal selesai harus sebelum atau sama dengan tanggal akhir pekerjaan.',
        ]);

        Subtask::where('id', $this->subtaskId)->update([
            'name' => $this->subtaskName,
            'pelaksana' => $this->subtaskJob,
            'biaya' => $this->subtaskValue,
            'sap' => $this->subtaskSAP,
            'rab' => $this->subtaskRAB,
            'rap' => $this->subtaskRAP,
            'rapp' => $this->subtaskRAPP,
            'started_at' => $this->subTaskStarted,
            'end_at' => $this->subTaskEnd,
            'keterangan' => $this->subTaskKeterangan,
            'completed' => $this->subtaskCompleted,
            'url' => $this->subtaskUrl,
            'status_id' => $this->subTaskStatus,
        ]);

        if ($this->subtaskRAP != null) {
            $this->notifApprove();
            $this->subtaskRAP = null;
        }

        $this->reset('subtaskName', 'subtaskJob', 'subtaskValue', 'subTaskStarted', 'subTaskEnd', 'subtaskCompleted', 'subTaskKeterangan', 'subtaskUrl', 'subTaskStatus', 'subtaskRAB', 'subtaskRAP', 'subtaskRAPP', 'subtaskSAP');
        $this->dispatch('close-taskModal', ['modalName' => 'editModal']);
        $this->dispatch('open-subtaskModal', ['modalName' => 'subTaskModal']);
        $this->dispatch('refreshDatatable');
        $this->alert('success', 'Subtask berhasil diperbarui!');
    }

    public function notifApprove()
    {
        $approvers = User::whereIn('role_id', [1, 2])->get();
        $user = Auth::user();

        if ($approvers->isNotEmpty()) {
            Notification::send($approvers, new ApproveNotification($user));
        }
    }


    public function closeSubtaskAddModal()
    {
        $this->reset('subtaskName', 'subtaskJob', 'subtaskValue', 'subTaskStarted', 'subTaskEnd', 'subtaskCompleted', 'subTaskKeterangan', 'subtaskUrl', 'subTaskStatus', 'subtaskRAB', 'subtaskRAP', 'subtaskRAPP', 'subtaskSAP');
    }

    public function saveTasklistStatus()
    {
        try {
            $this->validate([
                'tasklistStatus' => ['required', 'exists:statuses,id'],
            ]);

            $tasklist = Tasklist::findOrFail($this->tasklist->id);

            DB::beginTransaction();

            $tasklist->update([
                'status_id' => $this->tasklistStatus,
                'column_id' => $this->tasklistStatus == 1 ? 1 : $tasklist->column_id,
                'updated_at' => now(),
            ]);

            DB::commit();

            $this->tasklist = $tasklist->fresh(['status']);

            $this->alert('success', 'Status berhasil diperbarui!');

            return $this->tasklist->status->color;
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            $this->alert('error', 'Tasklist tidak ditemukan.');
            return null;
        } catch (ValidationException $e) {
            DB::rollBack();
            $this->alert('error', 'Status tidak valid.');
            return null;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error updating tasklist status:', [
                'tasklist_id' => $this->tasklist->id,
                'status_id' => $this->tasklistStatus,
                'error' => $e->getMessage()
            ]);
            $this->alert('error', 'Terjadi kesalahan saat memperbarui status.');
            return null;
        }
    }

    public function getSubtotal($taskId)
    {
        return Subtask::where('task_id', $taskId)->sum('rapp');
    }

    public function getTotalBiaya()
    {
        $columnIds = $this->tasklist->tasklistColumns->pluck('id')->toArray();
        $tasks = Task::whereIn('tasklist_column_id', $columnIds)->get();
        $total = 0;
        foreach ($tasks as $task) {
            $total += $this->getSubtotal($task->id);
        }
        return $total;
    }

    public function updateJadwal($id, $jadwal_awal, $jadwal_akhir)
    {
        $jadwal_awal = Carbon::parse($jadwal_awal);
        $jadwal_akhir = Carbon::parse($jadwal_akhir);
        $task = Task::find($id);
        $task->started_at = $jadwal_awal;
        $task->end_at = $jadwal_akhir;
        $task->save();
    }

    public function detailJadwal($id)
    {
        $task = Task::find($id);
        $this->idJadwalTask = $task->id;
        $this->namaAcaraTask = $task->name;
        $this->tanggalMulaiTask = $task->started_at;
        $this->tanggalSelesaiTask = $task->end_at;
        $this->statusJadwalTask = $task->status_id;
    }

    public function updateDetailJadwal()
    {
        $this->validate([
            'namaAcaraTask' => 'required',
            'tanggalMulaiTask' => ['required', 'date', 'after_or_equal:' . $this->tasklist->started_at, 'before_or_equal:' . $this->tasklist->end_at],
            'tanggalSelesaiTask' => ['date', 'before_or_equal:' . $this->tasklist->end_at, 'after_or_equal:' . $this->tasklist->started_at],
            'statusJadwalTask' => 'required',
        ], [
            'tanggalMulaiTask.after_or_equal' => 'Tanggal mulai tidak boleh lebih awal dari tanggal mulai projek.',
            'tanggalMulaiTask.before_or_equal' => 'tanggal melewati batasan projek.',
            'tanggalSelesaiTask.before_or_equal' => 'Tanggal melewati batasan projek.',
            'tanggalSelesaiTask.after_or_equal' => 'Tanggal tidak boleh lebih awal dari tanggal mulai projek.',
        ]);

        $id = $this->idJadwalTask;
        $task = Task::find($id);
        $task->name = $this->namaAcaraTask;
        $task->started_at = $this->tanggalMulaiTask;
        $task->end_at = $this->tanggalSelesaiTask;
        $task->status_id = $this->statusJadwalTask;
        $task->save();
        $this->dispatch('close-modal', ['modal-name' => 'modalJadwal']);
        $this->reset(['namaAcaraTask', 'tanggalMulaiTask', 'tanggalSelesaiTask', 'statusJadwalTask']);
        $this->alert('success', 'Jadwal berhasil diperbarui');

        $this->dispatch('refreshCalendar');

        return redirect(request()->header('Referer'));
    }

    public function render()
    {
        $events = [];
        $tasklist = DB::table('v_tasks_rekap')
            ->where('tasklist_id', $this->tasklist->id)
            ->get();
        $colors = ['#87A2FF', '#2A629A', '#FFD7C4', '#FFF4B5', '#A5B68D', '#A594F9', '#FFF078', '#FF885B', '#4B0082', '#32CD32'];

        $start = Carbon::createFromDate(1900, 1, 1);
        $end = Carbon::createFromDate(2100, 12, 31);

        while ($start <= $end) {
            if ($start->isDayOfWeek(Carbon::SATURDAY) || $start->isDayOfWeek(Carbon::SUNDAY)) {
                $events[] = [
                    'start' => $start->format('Y-m-d'),
                    'end' => $start->format('Y-m-d'),
                    'display' => 'background',
                    'backgroundColor' => '#ff0000',
                ];
            }
            $start->addDay();
        }

        foreach ($tasklist as $tasklist) {
            $tgl_mulai = Carbon::parse($tasklist->tgl_mulai_tasks);
            $tgl_selesai = Carbon::parse($tasklist->tgl_akhir_tasks);

            $events[] = [
                'id' => $tasklist->id_tasks,
                'title' => $tasklist->nama_tasks,
                'start' => $tgl_mulai,
                'end' => $tgl_selesai,
            ];
        }

        $tasks = DB::table('v_tasks_rekap')
            ->get();
        $statuses = Status::all();
        $statusSubtask = Status::whereNotIn('id', [4, 5])->get();
        return view('livewire.tasklist-detail', compact('statusSubtask', 'statuses'), [
            'detil' => $tasks,
            'userList' => $this->userList,
            'events' => $events,
        ]);
    }
}
