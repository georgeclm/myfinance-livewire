<?php

namespace App\Http\Livewire\Investasi\Deposito;

use Livewire\Component;

class Previous extends Component
{
    public $jumlah;
    public function submit()
    {
        $this->jumlah = str_replace('.', '', substr($this->jumlah, 4));

        $user = auth()->user();
        $user->previous_deposito = $this->jumlah;
        $user->save();

        $this->emit('success', 'Previous Deposito Earning Have Been Saved');

        $this->emit("hidemodalFund");
    }
    public function render()
    {
        return view('livewire.investasi.deposito.previous');
    }
}
