<?php

namespace App\Http\Livewire;

use App\Models\Utang as ModelsUtang;
use Livewire\Component;

class Utang extends Component
{
    public $utang;
    public $form;
    protected $listeners = ['refreshDebt'];
    public function refreshDebt()
    {
        $this->render();
    }
    public function editModal($primaryId)
    {
        $this->utang = ModelsUtang::findOrFail($primaryId);
        $this->form = [
            'nama' => $this->utang->nama,
            'jumlah' => 'Rp ' . number_format($this->utang->jumlah, 0, ',', '.'),
            'keterangan' => $this->utang->keterangan,
        ];
        $this->emit('editModal');
    }

    public function update()
    {
        $this->validate([
            'form.nama' => 'required',
            'form.keterangan' => 'nullable',
        ]);

        $this->utang->update([
            'nama' => $this->form['nama'],
            'keterangan' => $this->form['keterangan'],
        ]);

        session()->flash('success', 'Debt have been updated');
        $this->emit('hideEdit');
    }

    public function render()
    {
        return view('livewire.utang');
    }
}
