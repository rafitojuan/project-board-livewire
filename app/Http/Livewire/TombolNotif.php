<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TombolNotif extends Component
{
    public $notif = [];
    public $unread = 0;
    public $isDropdownOpen = false;

    public function mount()
    {
        $this->fetchNotif();
    }

    public function fetchNotif()
    {
        if (!$this->isDropdownOpen) {
            $user = auth()->user();
            $this->notif = $user->unreadNotifications->take(5);
            $this->unread = $user->unreadNotifications->count();
        }
    }

    public function toggleDropdown()
    {
        $this->isDropdownOpen = !$this->isDropdownOpen;
    }

    public function markAsRead($notifId)
    {
        $notif = auth()->user()->notifications->find($notifId);
        if ($notif) {
            $notif->markAsRead();
        }
        $this->fetchNotif();
    }

    public function render()
    {
        return view('livewire.tombol-notif');
    }
}
