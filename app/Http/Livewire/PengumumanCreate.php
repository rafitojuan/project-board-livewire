<?php

namespace App\Http\Livewire;

use App\Models\Announcement;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Crypt;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Glide | Pengumuman')]
class PengumumanCreate extends Component
{
    use LivewireAlert;

    public $judul;
    public $content;
    public $end_at;
    public $category;
    public $idTim;
    public $encryptedId;

    public function mount($id)
    {
        $this->encryptedId = $id;
        $id = Crypt::decryptString($id);
        $this->idTim = $id;
    }

    public function createPengumuman()
    {
        $this->validate([
            'judul' => 'required',
            'content' => 'required',
            'end_at' => 'required|date',
            'category' => 'required',
        ], [
            'judul.required' => 'Judul harus diisi',
            'content.required' => 'Konten harus diisi',
            'end_at.required' => 'Tanggal harus diisi',
            'end_at.date' => 'Tanggal harus berupa tanggal',
            'category.required' => 'Kategori harus diisi',
        ]);

        Announcement::create([
            'title' => $this->judul,
            'content' => $this->content,
            'end_at' => $this->end_at,
            'category' => $this->category,
            'team_id' => $this->idTim,
            'post_by' => auth()->user()->id,
            'status' => 'post',
        ]);

        $this->alert('success', 'Pengumuman berhasil di-publish');
        return redirect()->route('pengumuman.index', $this->encryptedId);
        $this->reset();
    }

    public function draft()
    {
        $this->validate([
            'judul' => 'required',
            'content' => 'required',
            'end_at' => 'required|date',
            'category' => 'required',
        ], [
            'judul.required' => 'Judul harus diisi',
            'content.required' => 'Konten harus diisi',
            'end_at.required' => 'Tanggal harus diisi',
            'end_at.date' => 'Tanggal harus berupa tanggal',
            'category.required' => 'Kategori harus diisi',
        ]);

        Announcement::create([
            'title' => $this->judul,
            'content' => $this->content,
            'end_at' => $this->end_at,
            'category' => $this->category,
            'team_id' => $this->idTim,
            'post_by' => auth()->user()->id,
            'status' => 'draft',
        ]);

        $this->alert('info', 'Pengumuman berhasil disimpan sebagai draft');
        return redirect()->route('pengumuman.index', $this->encryptedId);
        $this->reset();
    }

    public function render()
    {
        return view('livewire.pengumuman-create');
    }
}
