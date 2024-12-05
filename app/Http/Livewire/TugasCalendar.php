<?php

namespace App\Http\Livewire;

use App\Models\Subtask;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Glide | Kalendar')]
class TugasCalendar extends Component
{
    use LivewireAlert;

    public $namaAcara;
    public $tanggalMulai;
    public $tanggalSelesai;
    public $statusJadwal;
    public $idJadwal;
    protected $userId;

    public function mount()
    {
        $this->userId = auth()->id();
    }

    public function updateJadwal($id, $jadwal_awal, $jadwal_akhir)
    {
        $jadwal_awal = Carbon::parse($jadwal_awal);
        $jadwal_akhir = Carbon::parse($jadwal_akhir);
        $subtask = Subtask::find($id);
        $subtask->started_at = $jadwal_awal;
        $subtask->end_at = $jadwal_akhir;
        $subtask->save();
    }

    public function detailJadwal($id)
    {
        $subtask = Subtask::find($id);
        $this->idJadwal = $subtask->id;
        $this->namaAcara = $subtask->name;
        $this->tanggalMulai = $subtask->started_at;
        $this->tanggalSelesai = $subtask->end_at;
        $this->statusJadwal = $subtask->status_id;
    }

    public function updateDetailJadwal()
    {
        $id = $this->idJadwal;
        $subtask = Subtask::find($id);
        $subtask->name = $this->namaAcara;
        $subtask->started_at = $this->tanggalMulai;
        $subtask->end_at = $this->tanggalSelesai;
        $subtask->status_id = $this->statusJadwal;
        $subtask->save();
        $this->dispatch('close-modal', ['modal-name' => 'modalJadwal']);
        $this->reset(['namaAcara', 'tanggalMulai', 'tanggalSelesai', 'statusJadwal']);
        $this->alert('success', 'Jadwal berhasil diperbarui');

        $this->dispatch('refreshCalendar');
        $this->render();

        return redirect(request()->header('Referer'));
    }

    public function render()
    {
        $events = [];
        if (auth()->user()->role_id <= 2) {
            $tugas = Subtask::where('status_id', '!=', 6)->lazy();
        } else {
            $tugas = Subtask::where('pelaksana', $this->userId)->where('status_id', '!=', 6)->lazy();
        }
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

        foreach ($tugas as $tugas) {
            $jam_mulai = Carbon::parse($tugas->created_at)->format('H:i');
            $jam_selesai = Carbon::parse($tugas->updated_at)->format('H:i');
            $tgl_mulai = Carbon::parse($tugas->started_at)->format('Y-m-d') . ' ' . $jam_mulai;
            $tgl_selesai = Carbon::parse($tugas->end_at)->format('Y-m-d') . ' ' . $jam_selesai;

            $events[] = [
                'id' => $tugas->id,
                'title' => $tugas->name,
                'start' => $tgl_mulai,
                'end' => $tgl_selesai,
                'backgroundColor' => $colors[$tugas->pelaksana % count($colors)],
                'borderColor' => $colors[$tugas->pelaksana % count($colors)],
                'allDay' => false,
            ];
        }

        return view('livewire.tugas-calendar', [
            'events' => $events
        ]);
    }
}
