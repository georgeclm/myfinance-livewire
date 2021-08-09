<?php

namespace App\Http\Livewire\Partials;

use Livewire\Component;

class NoData extends Component
{

    public $message;
    public function render()
    {
        return view('livewire.partials.no-data');
    }
}
