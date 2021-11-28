<?php

namespace App\Http\Livewire\Partials;

use Livewire\Component;

class Balancewithasset extends Component
{
    protected $listeners = ['refreshBalance'];
    public function refreshBalance()
    {
        $this->render();
    }
    public function render()
    {
        return view('livewire.partials.balancewithasset');
    }
}
