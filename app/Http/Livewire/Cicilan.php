<?php

namespace App\Http\Livewire;

use App\Models\Jenisuang;
use Livewire\Component;

class Cicilan extends Component
{

    public $jenisuangs;

    public function mount()
    {
        $this->jenisuangs = Jenisuang::all();
    }

    public function render()
    {
        return view('livewire.cicilan');
    }
}
