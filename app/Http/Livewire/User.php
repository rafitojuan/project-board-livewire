<?php

namespace App\Http\Livewire;

use App\Models\User as ModelsUser;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Glide | User')]
class User extends Component
{
    use LivewireAlert;

    public $akun;

    public function tambahPengguna()
    {
        $this->validate([
            'akun' => 'required|email'
        ], [
            'akun.required' => 'Email harus diisi.',
            'akun.email' => 'Email tidak valid.'
        ]);

        ModelsUser::create([
            'name' => 'glideuser ' . ModelsUser::count() + 1,
            'email' => $this->akun,
            'dob' => '1999-01-01',
            'avatar' => 'images/default.jpg',
            'role_id' => 3,
            'password' => bcrypt('epiglideuser'),
        ]);

        $this->reset('akun');
        $this->dispatch('refreshDatatable');
        $this->alert('success', 'Akun berhasil ditambahkan.');
    }

    public function closeModal()
    {
        $this->dispatch('close-modal', ['modalName' => 'modalTambahUser']);
    }

    public function render()
    {
        return view('livewire.user');
    }
}
