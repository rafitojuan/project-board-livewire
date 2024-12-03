<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TombolNotif extends Component
{
    public $notif = [];
    public $unread = 0;
    public $isDropdownOpen = false;

    protected $listeners = ['refreshNotifications' => 'fetchNotif'];

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

    // public function openModal($notification)
    // {
    //     auth()->user()->notifications
    //         ->where('id', $notification['id'])
    //         ->update(['read_at' => now()]);

    //     $this->unread = auth()->user()
    //         ->unreadNotifications
    //         ->count();

    //     $this->dispatch('openNotificationModal', $notification);
    //     $this->isDropdownOpen = false;
    // }

    public function openModal($notification)
    {
        $this->dispatch('openNotificationModal', $notification);
        $this->isDropdownOpen = false;
    }

    public function markAsRead($notifId)
    {
        $notif = auth()->user()->notifications->find($notifId);
        if ($notif) {
            $notif->markAsRead();
        }
        $this->fetchNotif();
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->update(['read_at' => now()]);
        $this->unread = 0;
        $this->emit('refreshNotifications');
    }

    public function render()
    {
        return view('livewire.tombol-notif');
    }
}
