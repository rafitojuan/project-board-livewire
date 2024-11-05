<?php

namespace App\Http\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('User')]
class User extends Component
{
    public function render()
    {
        return view('livewire.user');
    }
}
