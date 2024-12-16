<?php

namespace App\Http\Livewire;

use App\Models\Team;
use Illuminate\Support\Facades\Crypt;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Glide | Tim Detail')]
class TimDetail extends Component
{
    use LivewireAlert;
    public $tim;

    public function mount($id)
    {
        try {
            $id = Crypt::decryptString($id);
            $this->tim = Team::with('teamAccess')->find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function render()
    {
        return view('livewire.tim-detail', [
            'team' => $this->tim,
        ]);
    }
}
