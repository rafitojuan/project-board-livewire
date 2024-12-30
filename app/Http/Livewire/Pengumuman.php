<?php

namespace App\Http\Livewire;

use App\Models\Announcement;
use Illuminate\Support\Facades\Crypt;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Glide | Pengumuman')]
class Pengumuman extends Component
{

    public $announcement;
    public $idTim;

    public function mount($id)
    {
        $this->idTim = $id;
        $id = Crypt::decryptString($id);
        $this->announcement = $this->fetchAnnouncementById($id);
    }

    public function fetchAnnouncementById($id)
    {
        $announcement = Announcement::where('team_id', $id)
            ->where('end_at', '>', now()->format('Y-m-d'))
            ->get();
        return $announcement;
    }

    public function render()
    {
        return view('livewire.pengumuman', [
            'announcement' => $this->announcement,
            'idTim' => $this->idTim,
        ]);
    }
}
