<?php

namespace App\Http\Livewire;

use App\Models\Announcement;
use Illuminate\Support\Facades\Crypt;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Glide | Pengumuman')]
class DetailPengumuman extends Component
{
    public $idTim;
    public $announcement;

    public function mount($id)
    {
        $id = Crypt::decryptString($id);
        $this->announcement = $this->fetchAnnouncementById($id);
        $this->idTim = Crypt::encryptString($this->announcement->team_id);
    }

    public function fetchAnnouncementById($id)
    {
        $announcement = Announcement::find($id);
        return $announcement;
    }

    public function render()
    {
        return view('livewire.detail-pengumuman', [
            'idTim' => $this->idTim,
            'announcement' => $this->announcement,
        ]);
    }
}
