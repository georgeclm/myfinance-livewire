<?php

namespace App\Http\Livewire;

use App\Models\Jenis;
use App\Models\User;
use Livewire\Component;

class Rekening extends Component
{


    public $jeniss;
    public $user;

    public function mount()
    {
        $this->jeniss = Jenis::with('user_rekenings')->get();
        $this->user = User::with('rekenings')->find(auth()->id());
    }
    public function render()
    {
        return view('livewire.rekening');
    }
}
