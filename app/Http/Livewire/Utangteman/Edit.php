<?php

namespace App\Http\Livewire\Utangteman;

use Livewire\Component;

class Edit extends Component
{
    public $utang;
    public $form = [
        'nama' => '',
        'jumlah' => '',
        'keterangan' => null,
    ];


    public function mount()
    {
        $this->form = [
            'nama' => $this->utang->nama,
            'jumlah' => 'Rp ' . number_format($this->utang->jumlah, 0, ',', '.'),
            'keterangan' => $this->utang->keterangan,
        ];
    }


    public function submit()
    {
        $this->validate([
            'form.nama' => 'required',
            'form.keterangan' => 'nullable',
        ]);

        $this->utang->update([
            'nama' => $this->form['nama'],
            'keterangan' => $this->form['keterangan'],
        ]);

        session()->flash('success', 'Friend Debt have been updated');
        return redirect(route('utangteman'));
    }

    public function render()
    {
        return view('livewire.utangteman.edit');
    }
}
