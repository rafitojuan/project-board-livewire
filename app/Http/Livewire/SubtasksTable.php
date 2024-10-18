<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Subtask;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;
use Livewire\WithPagination;
use Rappasoft\LaravelLivewireTables\Views\Actions\Action;

class SubtasksTable extends DataTableComponent
{
    use LivewireAlert, WithPagination;

    public $subtaskName;
    public $subtaskId;
    public $subtaskJob;
    public $subtaskValue;
    public $subTaskStarted;
    public $subTaskEnd;
    public $subtaskCompleted;
    public $subTaskKeterangan;
    public $subtaskUrl;
    public $id;
    public string $kode;
    protected $index = 0;

    protected $listeners = [
        'deleteSelectedConfirmed' => 'deleteSelectedConfirmed',
        'deleteConfirmed' => 'deleteConfirmed',
    ];

    public function builder(): Builder
    {
        return Subtask::query()->where('task_id', $this->kode);
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
            Column::make("Pekerjaan", "name")->view('components.name-field'),
            column::make("pelaksana")->hideIf(true),
            column::make("keterangan")->hideIf(true),
            column::make("url")->hideIf(true),
            DateColumn::make("Tanggal Mulai", "started_at")
                ->sortable()->searchable()->outputFormat('d F y')->emptyValue('N/A'),
            DateColumn::make("Tanggal Akhir", "end_at")
                ->sortable()->searchable()->outputFormat('d F y')->emptyValue('N/A'),
            Column::make("Biaya", "biaya")
                ->format(function ($value) {
                    return 'Rp' . number_format($value, 0, ',', '.');
                })
                ->sortable()->searchable(),
            BooleanColumn::make("Status", "completed")
                ->sortable()->searchable(),
            Column::make('Action', 'id')->view('components.action-buttons'),
        ];
    }


    public function edit($row)
    {
        $subtask = Subtask::findOrFail($row);
        $this->subtaskName = $subtask->name;
        $this->subtaskId = $subtask->id;
        $this->subtaskJob = $subtask->pelaksana;
        $this->subtaskValue = $subtask->biaya;
        $this->subTaskStarted = $subtask->started_at;
        $this->subTaskEnd = $subtask->end_at;
        $this->subtaskCompleted = $subtask->completed;
        $this->subTaskKeterangan = $subtask->keterangan;
        $this->subtaskUrl = $subtask->url;

        $this->dispatch('editSubtask', [
            'subtaskName' => $this->subtaskName,
            'subtaskId' => $this->subtaskId,
            'subtaskJob' => $this->subtaskJob,
            'subtaskValue' => $this->subtaskValue,
            'subTaskStarted' => $this->subTaskStarted,
            'subTaskEnd' => $this->subTaskEnd,
            'subtaskCompleted' => $this->subtaskCompleted,
            'subTaskKeterangan' => $this->subTaskKeterangan,
            'subtaskUrl' => $this->subtaskUrl
        ]);
    }


    public function delete($row)
    {
        Subtask::where('id', $row)->delete();
        $this->alert('success', 'Subtask berhasil dihapus!');
    }
}
