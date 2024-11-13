<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('EPI | Dashboard')]
class Dashboard extends Component
{
    public $dashboardData;
    public $tasklistsRekapActive;

    public function mount()
    {
        $this->loadDashboardData();
        $this->loadTasklistsRekapActive();
    }

    public function loadDashboardData()
    {
        $this->dashboardData = DB::table('v_dashboard_rekap')
            ->get();
    }

    public function loadTasklistsRekapActive()
    {
        $this->tasklistsRekapActive = DB::table('v_tasklists_rekap')
            ->whereNull('tgl_selesai_tasklist')
            ->get();
    }

    public function render()
    {
        return view('livewire.dashboard', [
            'dashboard' => $this->dashboardData,
            'tasklistsActive' => $this->tasklistsRekapActive,
        ]);
    }
}
