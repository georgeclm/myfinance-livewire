<?php

namespace App\Http\Livewire;

use App\Models\MutualFund as ModelsMutualFund;
use Livewire\Component;

class MutualFund extends Component
{
    public $mutual_funds;
    public function mount()
    {
        $this->mutual_funds = ModelsMutualFund::where('user_id', auth()->id())->where('unit', '!=', 0)->get();
    }
    public function render()
    {
        return view('livewire.mutual-fund');
    }
}
