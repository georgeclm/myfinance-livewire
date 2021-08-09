<?php

namespace App\Http\Livewire\Cicilan;

use Livewire\Component;

class Delete extends Component
{
    public $cicilan;
    public function delete()
    {
        $this->cicilan->delete();
        session()->flash('success', 'Repetition have been deleted');
        return redirect(route('cicilan'));
    }
    public function render()
    {
        return view('livewire.cicilan.delete');
    }
}
