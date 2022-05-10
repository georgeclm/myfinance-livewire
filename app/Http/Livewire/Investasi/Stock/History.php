<?php

namespace App\Http\Livewire\Investasi\Stock;

use App\Models\Stock;
use Livewire\Component;

class History extends Component
{
    public $stocks;
    public $sort_by;
    public $winrate = 0;

    public function render()
    {
        $this->stocks = Stock::where('user_id', auth()->id())->onlyTrashed();
        if ($this->sort_by  != '') {
            $this->stocks = $this->stocks->orderBy('gain_or_loss', ($this->sort_by == 'gain' ? 'desc' : 'asc'))->get();
        } else {
            $this->stocks = $this->stocks->orderBy('deleted_at', 'desc')->get();
        }
        if($this->stocks->count() != 0){
            $this->winrate = $this->stocks->where('gain_or_loss','<',0)->count()*100/$this->stocks->count();
        }
        return view('livewire.investasi.stock.history');
    }
}
