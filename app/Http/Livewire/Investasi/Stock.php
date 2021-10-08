<?php

namespace App\Http\Livewire\Investasi;

use App\Models\Stock as ModelsStock;
use Livewire\Component;

class Stock extends Component
{
    public $stocks;
    public function mount()
    {
        $this->stocks = ModelsStock::where('user_id', auth()->id())->where('lot', '!=', 0)->latest()->get();
    }
    public function render()
    {
        return view('livewire.investasi.stock');
    }
}
