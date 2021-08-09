<?php

namespace App\Http\Livewire\Partials;

use Livewire\Component;

class AlertCenter extends Component
{
    public $style = '';
    public $notifications;

    public function check_notif()
    {
        $this->style = ($this->style == '') ? 'show' : '';
        $notifs =  auth()->user()->cicil_notifications;
        foreach ($notifs as $notif) {
            $notif->check = 1;
            $notif->save();
        }
    }

    public function mount()
    {
        $this->notifications = auth()->user()->cicil_notifications;
    }
    public function render()
    {
        return view('livewire.partials.alert-center');
    }
}
