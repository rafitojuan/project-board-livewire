<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Subtask;
use Illuminate\Database\Eloquent\Builder;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;
use Livewire\WithPagination;

class SubtasksTable extends DataTableComponent
{
    use LivewireAlert, WithPagination;

    public $task_id;
    public $subtaskName;
    public $subtaskId;
    public $subtaskJob;
    public $subtaskValue;
    public $subtaskSAP;
    public $subtaskRAB;
    public $subtaskRAP;
    public $subtaskRAPP;
    public $subTaskStarted;
    public $subTaskEnd;
    public $subtaskCompleted;
    public $subTaskKeterangan;
    public $subtaskUrl;
    public $subTaskStatus;
    public $id;
    public string $kode;
    protected $index = 0;

    protected $listeners = [
        'deleteSelectedConfirmed' => 'deleteSelectedConfirmed',
        'deleteConfirmed' => 'deleteConfirmed',
    ];

    public function builder(): Builder
    {
        return Subtask::query()
            ->select('subtasks.*')
            ->with(['status' => function ($query) {
                $query->select('id', 'name');
            }])
            ->where('task_id', $this->kode)
            ->orderBy('id');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setBulkActions([
            'completeSelected' => 'Set as Complete',
            'deleteSelected' => 'Delete',
        ]);

        $this->setActionWrapperAttributes([
            'class' => 'space-x-4'
        ]);
    }

    public function completeSelected()
    {
        Subtask::whereIn('id', $this->getSelected())->update(['completed' => 1]);
        $this->clearSelected();
        $this->alert('success', 'Completed!');
    }

    public function deleteSelected()
    {
        $this->subtaskId = $this->getSelected();

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
            'onConfirmed' => 'deleteSelectedConfirmed',
        ]);
    }

    public function deleteSelectedConfirmed()
    {
        Subtask::whereIn('id', $this->subtaskId)->delete();
        $this->clearSelected();
        $this->alert('success', 'Subtask yang dipilih berhasil dihapus!');
    }

    public function columns(): array
    {
        $this->index = $this->getPage() > 1 ? ($this->getPage() - 1) * $this->perPage() : 0;
        return [
            Column::make('No', 'id')->format(fn($row) => ++$this->index)->sortable()->searchable(),
            Column::make("Pekerjaan", "name")->view('components.name-field')->searchable(),
            column::make("User", "user.name")->hideIf(true)->searchable(),
            column::make("keterangan")->hideIf(true)->searchable(),
            column::make("url")->hideIf(true)->searchable(),
            DateColumn::make("Tanggal Mulai", "started_at")
                ->sortable()->outputFormat('d F y')->emptyValue('N/A'),
            DateColumn::make("Tanggal Akhir", "end_at")
                ->sortable()->outputFormat('d F y')->emptyValue('N/A'),
            Column::make("RAB", "rab")
                ->format(function ($value) {
                    return $value == 0 ? '-' : 'Rp' . number_format($value, 0, ',', '.');
                })
                ->sortable()->searchable()->footer(function ($rows) {
                    $subtotal = $rows->sum('rab');
                    return 'Total RAB: Rp' . number_format($subtotal, 0, ',', '.');
                }),
            Column::make("RAP", "rap")
                ->format(function ($value) {
                    return $value == 0 ? '-' : 'Rp' . number_format($value, 0, ',', '.');
                })
                ->sortable()->searchable()->footer(function ($rows) {
                    $subtotal = $rows->sum('rap');
                    return 'Total RAP: Rp' . number_format($subtotal, 0, ',', '.');
                }),
            Column::make("RAPP", "rapp")
                ->format(function ($value) {
                    return $value == 0 ? '-' : 'Rp' . number_format($value, 0, ',', '.');
                })
                ->sortable()->searchable()->footer(function ($rows) {
                    $subtotal = $rows->sum('rapp');
                    return 'Total RAPP: Rp' . number_format($subtotal, 0, ',', '.');
                }),
            Column::make("Biaya", "biaya")
                ->format(function ($value) {
                    return $value == 0 ? '-' : 'Rp' . number_format($value, 0, ',', '.');
                })
                ->sortable()->searchable()->footer(function ($rows) {
                    $subtotal = $rows->sum('biaya');
                    return 'Subtotal: Rp' . number_format($subtotal, 0, ',', '.');
                }),
            Column::make("Status", "status.name")->view('components.status-badge')->searchable(),
            Column::make("Status", "status.color")->hideIf(true),
            Column::make('Action', 'id')->view('components.action-buttons')->searchable(),
        ];
    }


    public function edit($row)
    {
        $subtask = Subtask::with('status')->findOrFail($row);
        $this->subtaskName = $subtask->name;
        $this->subtaskId = $subtask->id;
        $this->subtaskJob = $subtask->pelaksana;
        $this->subtaskValue = $subtask->biaya;
        $this->subTaskStarted = $subtask->started_at;
        $this->subTaskEnd = $subtask->end_at;
        $this->subtaskCompleted = $subtask->completed;
        $this->subTaskKeterangan = $subtask->keterangan;
        $this->subtaskUrl = $subtask->url;
        $this->subTaskStatus = $subtask->status_id;
        $this->subtaskRAB = (int)($subtask->rab);
        $this->subtaskRAP = (int)($subtask->rap);
        $this->subtaskRAPP = (int)($subtask->rapp);
        $this->subtaskSAP = (bool)$subtask->sap;

        $this->dispatch('editSubtask', [
            'subtaskName' => $this->subtaskName,
            'subtaskId' => $this->subtaskId,
            'subtaskJob' => $this->subtaskJob,
            'subtaskValue' => $this->subtaskValue,
            'subTaskStarted' => $this->subTaskStarted,
            'subTaskEnd' => $this->subTaskEnd,
            'subtaskCompleted' => $this->subtaskCompleted,
            'subTaskKeterangan' => $this->subTaskKeterangan,
            'subtaskUrl' => $this->subtaskUrl,
            'subTaskStatus' => $this->subTaskStatus,
            'subtaskRAB' => $this->subtaskRAB,
            'subtaskRAP' => $this->subtaskRAP,
            'subtaskRAPP' => $this->subtaskRAPP,
            'subtaskSAP' => $this->subtaskSAP,
        ]);
    }

    public function delete($row)
    {
        Subtask::where('id', $row)->delete();
        $this->alert('success', 'Subtask berhasil dihapus!');
    }
}
