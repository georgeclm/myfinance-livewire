<?php

namespace App\Http\Livewire;

use App\Models\Jenisuang;
use Livewire\Component;

class Transaction extends Component
{

    public $jenisuangs;
    public $q = 0;
    public $daterange = null;

    public function mount()
    {
        $this->jenisuangs = Jenisuang::all();
    }
    public function render()
    {
        return view('livewire.transaction');
    }
}
