<?php

namespace App\Http\Livewire\Partials;

use Livewire\Component;

class Balance extends Component
{
    public $daterange;
    public function render()
    {
        return view('livewire.partials.balance');
    }
}
