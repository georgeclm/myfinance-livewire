<?php

namespace App\Http\Livewire;

use App\Models\Utangteman as ModelsUtangteman;
use Livewire\Component;

class Utangteman extends Component
{
    public $utangs;
    public $utang;
    public $form;
    protected $listeners = ['refreshFriendDebt'];
    public function refreshFriendDebt()
    {
        $this->render();
    }
    public function editModal($primaryId)
    {
        $this->utang = ModelsUtangteman::findOrFail($primaryId);
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

        $this->emit('success', 'Friend Debt have been updated');

        $this->emit('hideEdit');
    }

    public function render()
    {
        $this->utangs = ModelsUtangteman::where('user_id', auth()->id())->where('lunas', 0)->latest()->get();

        return view('livewire.utangteman');
    }
}
