<?php

namespace App\Http\Livewire\Investasi\Stock;

use App\Models\Stock;
use Livewire\Component;

class History extends Component
{
    public $stocks;
    public function mount()
    {
        $this->stocks = Stock::where('user_id', auth()->id())->onlyTrashed()->latest()->get();
    }
    public function render()
    {
        return view('livewire.investasi.stock.history');
    }
}
