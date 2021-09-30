<?php

namespace App\Http\Livewire\Investasi\Stock;

use Livewire\Component;

class Previous extends Component
{
    public $jumlah;
    public function submit()
    {
        $this->jumlah = str_replace('.', '', substr($this->jumlah, 4));

        $user = auth()->user();
        $user->previous_stock = $this->jumlah;
        $user->save();

        session()->flash('success', 'Previous Stock Earning Have Been Saved');
        return redirect(route('stock'));
    }
    public function render()
    {
        return view('livewire.investasi.stock.previous');
    }
}
