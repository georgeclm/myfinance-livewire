<?php

namespace App\Http\Livewire\Rekening;

use App\Models\Rekening;
use Livewire\Component;

class Edit extends Component
{

    public $jeniss;
    public $rekening;
    public $form = [
        'jenis_id' => '',
        'nama_akun' => '',
        'nama_bank' => null,
        'saldo_sekarang' => '',
        'saldo_mengendap' => null,
        'keterangan' => null,
    ];

    public function delete()
    {
        $this->rekening->delete();
        session()->flash('success', 'Pocket have been deleted');
        return redirect(route('rekening'));
    }

    public function submit()
    {
        if ($this->form['saldo_mengendap'] != null) {
            $this->form['saldo_mengendap'] = str_replace('.', '', substr($this->form['saldo_mengendap'], 4));
        }
        $this->validate([
            'form.nama_akun' => 'required',
            'form.nama_bank' => 'nullable',
            'form.saldo_mengendap' => ['nullable', 'numeric'],
            'form.keterangan' => 'nullable',
        ]);

        $this->rekening->update([
            'nama_akun' => $this->form['nama_akun'],
            'nama_bank' => $this->form['nama_bank'],
            'saldo_mengendap' => $this->form['saldo_mengendap'],
            'keterangan' => $this->form['keterangan'],
        ]);

        session()->flash('success', 'Pocket have been updated');
        return redirect(route('rekening'));
    }

    public function mount()
    {
        $this->form = [
            'jenis_id' => $this->rekening->jenis_id,
            'nama_akun' => $this->rekening->nama_akun,
            'nama_bank' => $this->rekening->nama_bank,
            'saldo_sekarang' => 'Rp ' . number_format($this->rekening->saldo_sekarang),
            'saldo_mengendap' => $this->rekening->saldo_mengendap,
            'keterangan' => $this->rekening->keterangan,
        ];
    }
    public function render()
    {
        return view('livewire.rekening.edit');
    }
}
