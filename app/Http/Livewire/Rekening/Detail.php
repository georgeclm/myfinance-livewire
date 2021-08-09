<?php

namespace App\Http\Livewire\Rekening;

use App\Models\Jenisuang;
use App\Models\Rekening;
use App\Models\Transaction;
use Livewire\Component;

class Detail extends Component
{

    public $rekening;
    public $jenisuangs;
    public $q = 0;

    public function mount(Rekening $rekening)
    {
        $this->rekening = $rekening;
        $this->jenisuangs = Jenisuang::all();
    }


    public function render()
    {
        // dd($this->jenisuangs[0]->user_transactions($this->q));
        return view('livewire.rekening.detail');
    }
}
