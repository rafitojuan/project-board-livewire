<?php

namespace App\Http\Livewire;

use App\Models\Team;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Glide | Tim')]
class Tim extends Component
{
    use LivewireAlert;
    public $search = '';

    public $teams;
    public $teamPusat;
    public $teamDivision;
    public $teamProject;

    public $idTim;
    public $deskripsiTim;
    public $namaTim;
    public $kategoriTim;
    public $warnaTim;


    public function mount()
    {
        // $this->authorize('viewAny', Team::class);
        $this->teams = $this->getAllTeam();
        $this->teamPusat = $this->getPusatTeam();
        $this->teamDivision = $this->getDivisionTeam();
        $this->teamProject = $this->getProjectTeam();
    }

    public function getAllTeam()
    {
        $team = Team::with('teamAccess')->where('is_archive', 0)->get();
        return $team;
    }

    public function getPusatTeam()
    {
        $teamPusat = Team::with('teamAccess')->where('is_archive', 0)->where('kategori', 1)->get();
        return $teamPusat;
    }

    public function getDivisionTeam()
    {
        $teamDivision = Team::with('teamAccess')->where('is_archive', 0)->where('kategori', 2)->get();
        return $teamDivision;
    }

    public function getProjectTeam()
    {
        $teamProject = Team::with('teamAccess')->where('is_archive', 0)->where('kategori', 3)->get();
        return $teamProject;
    }


    public function updatedSearch()
    {
        $this->teams = Team::where('nama_tim', 'like', '%' . $this->search . '%')->get();
        $this->teamPusat = $this->getPusatTeam();
        $this->teamDivision = $this->getDivisionTeam();
        $this->teamProject = $this->getProjectTeam();
    }


    public function storeTeam()
    {
        $this->validate([
            'namaTim' => 'required|min:3',
            'deskripsiTim' => 'required',
            'kategoriTim' => 'required',
        ], [
            'namaTim.required' => 'Nama tim harus diisi',
            'deskripsiTim.required' => 'Deskripsi tim harus diisi',
            'kategoriTim.required' => 'Tentukan kategori tim',
        ]);

        Team::create([
            'nama_tim' => $this->namaTim,
            'deskripsi' => $this->deskripsiTim,
            'kategori' => $this->kategoriTim,
            'dibuat_oleh' => auth()->user()->id,
        ]);

        $this->teams = $this->getAllTeam();
        $this->teamPusat = $this->getPusatTeam();
        $this->teamDivision = $this->getDivisionTeam();
        $this->teamProject = $this->getProjectTeam();
        $this->dispatch('close-modal', ['modalName' => 'modalTambahTim']);

        $this->reset('namaTim', 'deskripsiTim', 'kategoriTim');
        $this->alert('success', 'Berhasil menambahkan tim');
    }

    public function teamArchive($id)
    {
        $team = Team::find($id);
        $team->update([
            'is_archive' => 1
        ]);

        $this->teams = $this->getAllTeam();
        $this->teamPusat = $this->getPusatTeam();
        $this->teamDivision = $this->getDivisionTeam();
        $this->teamProject = $this->getProjectTeam();
        $this->alert('success', 'Tim masuk kedalam arsip');
    }

    public function fetchTeamToEdit($team)
    {
        $this->idTim = $team['id'];
        $this->namaTim = $team['nama_tim'];
        $this->deskripsiTim = $team['deskripsi'];
        $this->kategoriTim = $team['kategori'];
        $this->warnaTim = $team['warna_tim'];
    }

    public function updateTeam()
    {
        $this->validate([
            'namaTim' => 'required|min:3',
            'deskripsiTim' => 'required',
            'kategoriTim' => 'required',
        ], [
            'namaTim.required' => 'Nama tim harus diisi',
            'deskripsiTim.required' => 'Deskripsi tim harus diisi',
            'kategoriTim.required' => 'Tentukan kategori tim',
        ]);

        $team = Team::find($this->idTim);
        $team->update([
            'nama_tim' => $this->namaTim,
            'deskripsi' => $this->deskripsiTim,
            'kategori' => $this->kategoriTim,
        ]);

        $this->teams = $this->getAllTeam();
        $this->teamPusat = $this->getPusatTeam();
        $this->teamDivision = $this->getDivisionTeam();
        $this->teamProject = $this->getProjectTeam();

        $this->dispatch('close-modal', ['modalName' => 'modalEditTim']);
        $this->alert('success', 'Berhasil mengubah tim');
        $this->reset('namaTim', 'deskripsiTim', 'kategoriTim');
    }

    public function changeTeamColor()
    {
        $this->validate([
            'warnaTim' => 'required',
        ], [
            'warnaTim.required' => 'Pilih warna tim',
        ]);

        $team = Team::find($this->idTim);
        $team->update([
            'warna_tim' => $this->warnaTim,
        ]);

        $this->teams = $this->getAllTeam();
        $this->teamPusat = $this->getPusatTeam();
        $this->teamDivision = $this->getDivisionTeam();
        $this->teamProject = $this->getProjectTeam();

        $this->dispatch('close-modal', ['modalName' => 'modalUbahWarnaTim']);
        $this->alert('success', 'Berhasil mengubah warna tim');
        $this->reset('warnaTim', 'idTim');
    }

    public function render()
    {
        return view('livewire.tim', [
            'teams' => $this->teams,
            'teamPusat' => $this->teamPusat,
            'teamDivision' => $this->teamDivision,
            'teamProject' => $this->teamProject,
        ]);
    }
}
