<?php

namespace App\Http\Livewire;

use App\Models\Utangteman as ModelsUtangteman;
use Livewire\Component;

class Utangteman extends Component
{
    public $utangs;

    public function mount()
    {
        $this->utangs = ModelsUtangteman::where('user_id', auth()->id())->where('lunas', 0)->latest()->get();
    }

    public function render()
    {
        return view('livewire.utangteman');
    }
}
