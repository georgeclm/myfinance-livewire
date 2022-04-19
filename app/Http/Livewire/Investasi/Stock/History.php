<?php

namespace App\Http\Livewire\Investasi\Stock;

use App\Models\Stock;
use Livewire\Component;

class History extends Component
{
    public $stocks;
    public $sort_by;


    public function render()
    {
        $this->stocks = Stock::where('user_id', auth()->id())->onlyTrashed();
        if ($this->sort_by  != '') {
            $this->stocks = $this->stocks->orderBy('gain_or_loss', ($this->sort_by == 'gain' ? 'desc' : 'asc'))->get();
        } else {
            $this->stocks = $this->stocks->orderBy('deleted_at', 'desc')->get();
        }
        return view('livewire.investasi.stock.history');
    }
}
