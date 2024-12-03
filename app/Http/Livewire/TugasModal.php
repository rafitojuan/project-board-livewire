<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TugasModal extends Component
{
    public $isOpen = false;
    public $notification = null;

    protected $listeners = ['openNotificationModal' => 'open'];

    public function open($notificationData)
    {
        $this->notification = $notificationData;
        $this->isOpen = true;
    }

    public function close()
    {
        $this->isOpen = false;
        $this->notification = null;
    }

    public function render()
    {
        return view('livewire.tugas-modal');
    }
}
