<?php

namespace App\Http\Livewire\Rekening;

use Livewire\Component;

class Delete extends Component
{

    public $rekening;

    public function delete()
    {
        $this->rekening->delete();
        session()->flash('success', 'Pocket have been deleted');
        return redirect(route('rekening'));
    }

    public function render()
    {
        return view('livewire.rekening.delete');
    }
}
