<?php

namespace App\Http\Livewire\Investasi\P2p;

use Livewire\Component;

class Previous extends Component
{
    public $jumlah;
    public function submit()
    {
        $this->jumlah = str_replace('.', '', substr($this->jumlah, 4));

        $user = auth()->user();
        $user->previous_p2p = $this->jumlah;
        $user->save();

        session()->flash('success', 'Previous P2P Earning Have Been Saved');
        return redirect(route('p2p'));
    }
    public function render()
    {
        return view('livewire.investasi.p2p.previous');
    }
}
