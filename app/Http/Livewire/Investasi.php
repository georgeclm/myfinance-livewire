<?php

namespace App\Http\Livewire;

use App\Models\Investation;
use Livewire\Component;

class Investasi extends Component
{
    public $investations;

    public function mount()
    {
        $this->investations = Investation::all();
    }
    public function render()
    {
        return view('livewire.investasi');
    }
}
