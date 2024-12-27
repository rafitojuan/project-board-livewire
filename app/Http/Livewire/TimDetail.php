<?php

namespace App\Http\Livewire;

use App\Models\Team;
use App\Models\TeamAccess;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Glide | Tim Detail')]
class TimDetail extends Component
{
    use LivewireAlert;

    public $tim;
    public $anggota;
    public $selectPeranAnggota = [];
    public $selectedUsers = [];

    #[On('usersSelected')]
    public function setSelectedUsers($users)
    {
        $this->selectedUsers = $users;
    }

    public function mount($id)
    {
        try {
            $id = Crypt::decryptString($id);
            $this->tim = Team::with('teamAccess')->findOrFail($id);
            $this->fetchAnggota($id);
        } catch (\Throwable $th) {
            Log::error('Failed to decrypt team ID: ' . $th->getMessage());
            abort(404, 'Tim tidak ditemukan');
        }
    }

    public function undangAnggota()
    {
        $this->validate([
            'selectedUsers' => 'required|array',
        ], [
            'selectedUsers.required' => 'Pilih minimal satu anggota.',
        ]);

        DB::transaction(function () {
            foreach ($this->selectedUsers as $userId) {
                TeamAccess::updateOrCreate([
                    'team_id' => $this->tim->id,
                    'user_id' => $userId,
                ]);
            }
        });

        $this->dispatch('refreshDatatable');
        $this->reset('selectedUsers');
        $this->alert('success', 'Anggota berhasil ditambahkan!');
        $this->dispatch('close-modal', 'modalTambahAnggota');
    }

    public function fetchAnggota($id)
    {
        $this->anggota = TeamAccess::with(['user' => function ($query) {
            $query->withDefault([
                'name' => 'Pengguna Tidak Ditemukan',
                'avatar' => 'default-avatar.png',
            ]);
        }])
            ->where('team_id', $id)
            ->where('user_id', '!=', $this->tim->dibuat_oleh)
            ->get();
    }

    public function simpanAksesTim()
    {
        $this->validate([
            'selectPeranAnggota' => 'required',
        ], [
            'selectPeranAnggota.required' => 'Pilih peran anggota.',
        ]);

        DB::transaction(function () {
            foreach ($this->anggota as $value) {
                if (!isset($this->selectPeranAnggota[$value->user_id])) {
                    throw new \Exception('Role not selected for member ' . $value->user_id);
                }

                $value->update([
                    'role_team' => $this->selectPeranAnggota[$value->user_id],
                ]);
            }
        });

        $this->alert('success', 'Peran anggota berhasil disimpan!');
        $this->dispatch('close-modal', 'modalAksesTim');
    }

    public function render()
    {
        return view('livewire.tim-detail', [
            'team' => $this->tim,
            'anggota' => $this->anggota,
        ]);
    }
}
