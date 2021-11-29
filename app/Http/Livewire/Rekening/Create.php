<?php

namespace App\Http\Livewire\Rekening;

use App\Http\Livewire\Rekening;
use App\Models\Jenis;
use App\Models\Rekening as ModelsRekening;
use Livewire\Component;

class Create extends Component
{

    public $jeniss;
    public $form = [
        'jenis_id' => '',
        'nama_akun' => '',
        'nama_bank' => null,
        'saldo_sekarang' => '',
        'saldo_mengendap' => null,
        'keterangan' => null,
        'user_id' => ''
    ];


    public function submit()
    {
        $this->form['user_id'] = auth()->id();
        $this->form['saldo_sekarang'] = str_replace('.', '', substr($this->form['saldo_sekarang'], 4));
        if ($this->form['saldo_mengendap'] != null) {
            $this->form['saldo_mengendap'] = str_replace('.', '', substr($this->form['saldo_mengendap'], 4));
        }
        $this->validate([
            'form.jenis_id' => ['required', 'in:' . Jenis::pluck('id')->implode(',')],
            'form.nama_akun' => 'required',
            'form.nama_bank' => 'nullable',
            'form.saldo_sekarang' => ['required', 'numeric'],
            'form.saldo_mengendap' => ['nullable', 'numeric'],
            'form.keterangan' => 'nullable',
        ]);

        ModelsRekening::create($this->form);
        $this->emit('success', 'New Pocket have been registered');
        $this->emit("hideCreatePocket");
        $this->emit('refreshBalance');
        $this->emit('refreshPocket');
        $this->emit('refreshView');
        $this->resetErrorBag();
        $this->form = [
            'jenis_id' => '',
            'nama_akun' => '',
            'nama_bank' => null,
            'saldo_sekarang' => '',
            'saldo_mengendap' => null,
            'keterangan' => null,
            'user_id' => ''
        ];
        // return redirect()->to('/pockets');
    }
    public function render()
    {
        return view('livewire.rekening.create');
    }
}
