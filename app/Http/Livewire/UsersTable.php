<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;
use Rappasoft\LaravelLivewireTables\Views\Columns\ImageColumn;

class UsersTable extends DataTableComponent
{
    use LivewireAlert, WithPagination;

    public $teamId;
    public $selectUser = [];

    // protected $model = User::class;

    public function builder(): Builder
    {
        return User::query()
            ->select('users.*')
            ->whereNotIn('users.id', function ($query) {
                $query->select('user_id')
                    ->from('team_accesses')
                    ->where('team_id', $this->teamId);
            })
            ->whereNotIn('users.id', function ($query) {
                $query->select('dibuat_oleh')
                    ->from('teams')
                    ->where('id', $this->teamId);
            })
            ->with(['role' => function ($query) {
                $query->select('id', 'name');
            }])
            ->orderBy('users.id');
    }

    // return User::query()
    //         ->select('users.*')
    //         ->whereNotIn('users.id', function ($query) {
    //             $query->select('user_id')
    //                 ->from('team_accesses');
    //         })
    //         ->with(['role' => function ($query) {
    //             $query->select('id', 'name');
    //         }])
    //         ->orderBy('users.id');

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function updatedSelectUser()
    {
        $this->dispatch('usersSelected', $this->selectUser);
    }

    public function columns(): array
    {
        return [
            Column::make("No", "id")
                ->sortable()->searchable(),
            Column::make("avatar", "avatar")
                ->sortable()->searchable()->hideIf(true),
            Column::make("role", "role.name")
                ->sortable()->searchable()->hideIf(true),
            ImageColumn::make('Avatar')
                ->location(
                    fn($row) => asset($row->avatar)
                )
                ->attributes(fn($row) => [
                    'class' => 'rounded-circle',
                    'alt' => $row->name . ' Avatar',
                    'width' => '40',
                    'height' => '40',
                ])
                ->view('components.user-field')->searchable()->hideIf(true),
            Column::make("Nama", "name")
                ->view('components.user-field')->sortable()->searchable(),
            Column::make('', 'id')->view('components.user-select')->searchable(),
        ];
    }


    public function delete($row)
    {
        User::where('id', $row)->delete();
        $this->alert('success', 'User berhasil dihapus!');
    }
}
