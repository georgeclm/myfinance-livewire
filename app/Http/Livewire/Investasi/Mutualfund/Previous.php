<?php

namespace App\Http\Livewire\Investasi\Mutualfund;

use Livewire\Component;

class Previous extends Component
{
    public $jumlah;
    public function submit()
    {
        $this->jumlah = str_replace('.', '', substr($this->jumlah, 4));

        $user = auth()->user();
        $user->previous_reksadana = $this->jumlah;
        $user->save();

        session()->flash('success', 'Previous Mutual Fund Earning Have Been Saved');
        return redirect(route('mutualfund'));
    }
    public function render()
    {
        return view('livewire.investasi.mutualfund.previous');
    }
}