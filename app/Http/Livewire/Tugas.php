<?php

namespace App\Http\Livewire;

use App\Models\Status;
use App\Models\Subtask;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('EPI | Tugas')]
class Tugas extends Component
{
    use WithPagination, LivewireAlert;
    public $idTugas;
    public $tugasUser;
    public $dashboardUser;
    public $namaTugas;
    public $namaPelaksana;
    public $mulaiTugas;
    public $akhirTugas;
    public $biayaTugas;
    public $keteranganTugas;
    public $statusTugas;
    public $urlTugas;
    public $pelaksanaList;
    public $statusList;

    public function mount()
    {
        $this->tugasUser();
        $this->dashboardUser();
        $this->statusList();
        $this->pelaksanaList();
    }

    public function tugasUser()
    {
        $data = DB::table('v_tugas_user')
            ->get()
            ->filter(function ($project) {
                $kegiatanList = json_decode($project->kegiatan_list ?? '[]', true);

                return collect($kegiatanList)->some(function ($kegiatan) {
                    if (!isset($kegiatan['subtasks']) || empty($kegiatan['subtasks'])) {
                        return false;
                    }

                    if (Auth::user()?->role_id <= 2) {
                        return collect($kegiatan['subtasks'])->some(function ($subtask) {
                            return isset($subtask['rap']) && $subtask['rap'] !== null;
                        });
                    }

                    $kegiatan['subtasks'] = collect($kegiatan['subtasks'])->map(function ($subtask) {
                        if (isset($subtask['rap'])) {
                            $subtask['rap'] = null;
                        }
                        return $subtask;
                    })->all();

                    return collect($kegiatan['subtasks'])->some(function ($subtask) {
                        return isset($subtask['pelaksana_id']) && $subtask['pelaksana_id'] === Auth::user()?->id;
                    });
                });
            });
        $this->tugasUser = $data;
    }

    public function dashboardUser()
    {
        $this->dashboardUser = DB::table('v_dashboard_rekap_user')
            ->where('id_pelaksana', Auth::user()?->id)
            ->first();

        return $this->dashboardUser;
    }

    public function pelaksanaList()
    {
        $this->pelaksanaList = User::all();
        return $this->pelaksanaList;
    }

    public function statusList()
    {
        $this->statusList = Status::whereNotIn('id', [2, 3])->get();
        return $this->statusList;
    }

    public function showTugasUser($tugasUser)
    {
        $tugas = Subtask::where('id', $tugasUser)->first();
        $this->idTugas = $tugas->id;
        $this->namaTugas = $tugas->name;
        $this->namaPelaksana = $tugas->pelaksana;
        $this->mulaiTugas = $tugas->started_at;
        $this->akhirTugas = $tugas->end_at;
        $this->biayaTugas = $tugas->biaya;
        $this->keteranganTugas = $tugas->keterangan;
        $this->statusTugas = $tugas->status_id;
        $this->urlTugas = $tugas->url;
        $this->dispatch('showTugasUser', $tugasUser);
    }

    public function updateTugas()
    {
        $this->validate([
            'namaTugas' => 'required|min:3',
            'namaPelaksana' => 'required',
            'mulaiTugas' => 'required|date',
            'akhirTugas' => 'required|date|after:mulaiTugas',
            'biayaTugas' => 'required|numeric',
            'keteranganTugas' => 'required',
            'statusTugas' => 'required',
            'urlTugas' => 'nullable|url',
        ], [
            'namaTugas.required' => 'Nama tidak boleh kosong!',
            'namaTugas.min' => 'Nama minimal 3 karakter!',
            'namaPelaksana.required' => 'Nama pelaksana tidak boleh kosong!',
            'mulaiTugas.required' => 'Tanggal mulai tidak boleh kosong!',
            'akhirTugas.required' => 'Tanggal selesai tidak boleh kosong!',
            'akhirTugas.after' => 'Tanggal selesai harus setelah tanggal mulai!',
            'biayaTugas.required' => 'Biaya tidak boleh kosong!',
            'biayaTugas.numeric' => 'Biaya harus berupa angka!',
            'keteranganTugas.required' => 'Keterangan tidak boleh kosong!',
            'statusTugas.required' => 'Status tidak boleh kosong!',
            'urlTugas.url' => 'URL tidak valid!',
        ]);

        $data = [
            'name' => $this->namaTugas,
            'pelaksana' => $this->namaPelaksana,
            'started_at' => $this->mulaiTugas,
            'end_at' => $this->akhirTugas,
            'biaya' => $this->biayaTugas,
            'keterangan' => $this->keteranganTugas,
            'status_id' => $this->statusTugas,
            'url' => $this->urlTugas,
        ];
        $tugas = Subtask::find($this->idTugas);

        $tugas->update($data);
        $this->tugasUser();
        $this->alert('success', 'Tugas berhasil diupdate!');
    }

    public function render()
    {
        return view('livewire.tugas', [
            'tugasUser' => $this->tugasUser,
            'userData' => $this->dashboardUser,
            'statusList' => $this->statusList,
            'pelaksanaList' => $this->pelaksanaList,
        ]);
    }
}
