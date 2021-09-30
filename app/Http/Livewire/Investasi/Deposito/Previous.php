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

        session()->flash('success', 'Previous Deposito Earning Have Been Saved');
        return redirect(route('deposito'));
    }
    public function render()
    {
        return view('livewire.investasi.deposito.previous');
    }
}
