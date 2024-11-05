<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class UsersTable extends DataTableComponent
{
    use LivewireAlert, WithPagination;


    protected $model = User::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("No", "id")
                ->sortable()->searchable(),
            Column::make("Name", "name")
                ->sortable()->searchable(),
            Column::make("Email", "email")
                ->sortable()->searchable(),
            Column::make("Role", "role.name")
                ->sortable()->searchable(),
            Column::make("Division", "division.divisi")
                ->sortable()->searchable()
                ->format(fn($value) => $value ?? '-'),
            Column::make('Action', 'id')->view('components.action-buttons')->searchable(),
        ];
    }

    public function delete($row)
    {
        User::where('id', $row)->delete();
        $this->alert('success', 'User berhasil dihapus!');
    }
}
