<?php

namespace App\Http\Livewire;

use App\Models\Subtask;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Collection;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Glide | Kalendar')]
class TugasCalendar extends Component
{
    protected $userId;

    public function mount()
    {
        $this->userId = auth()->id();
    }

    public function render()
    {
        $events = [];
        $tugas = Subtask::where('pelaksana', $this->userId)->where('status_id', '!=', 6)->get();
        $colors = ['#87A2FF', '#2A629A', '#FFD7C4', '#FFF4B5', '#A5B68D', '#A594F9', '#FFF078', '#FF885B', '#4B0082', '#32CD32'];
        $randomColor = $colors[array_rand($colors)];
        $userColor = $colors[$this->userId % count($colors)];

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
                'backgroundColor' => $userColor,
                'borderColor' => $userColor,
                'allDay' => false,
            ];
        }

        return view('livewire.tugas-calendar', [
            'events' => $events
        ]);
    }
}
