<?php

namespace App\Http\Livewire;

use App\Models\Jenisuang;
use Livewire\Component;

class Transaction extends Component
{

    public $jenisuangs;
    public $daterange = null;

    public function mount()
    {
        $this->jenisuangs = Jenisuang::with('user_transactions')->get();
    }
    public function render()
    {
        return view('livewire.transaction');
    }
}
