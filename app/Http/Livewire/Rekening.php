<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\CategoryMasuk;
use App\Models\Jenis;
use App\Models\Rekening as ModelsRekening;
use App\Models\Transaction;
use App\Models\User;
use Livewire\Component;

class Rekening extends Component
{


    public $jeniss;
    public $user;
    public $editJenis = 1;
    public $form;
    public $rekening;
    public $name;
    public $saldo;
    public $update_saldo;
    protected $listeners = ['refreshPocket'];

    public function refreshPocket()
    {
        $this->render();
    }
    public function editModal($id)
    {
        $this->rekening  = ModelsRekening::findOrFail($id);
        $this->form = $this->rekening->toArray();
        $this->form['saldo_sekarang'] = 'Rp  ' . number_format($this->rekening->saldo_sekarang, 0, ',', '.');
        $this->form['saldo_mengendap'] = 'Rp  ' . number_format($this->rekening->saldo_mengendap, 0, ',', '.');
        $this->editJenis = $this->rekening->jenis_id;
        $this->emit("editModal");
        $this->emit('run');
    }
    public function deleteModal($id)
    {
        $this->rekening  = ModelsRekening::findOrFail($id);
        $this->name = $this->rekening->nama_akun;
        $this->emit("deleteModal");
    }
    public function adjustModal($id)
    {
        $this->rekening  = ModelsRekening::findOrFail($id);
        $this->name = $this->rekening->nama_akun;
        $this->saldo = $this->rekening->saldo_sekarang;
        $this->emit("adjustModal");
    }
    public function delete()
    {
        $this->rekening->delete();
        $this->emit("hideDelete");
        $this->emit('refreshBalance');
        session()->flash('success', 'Pocket have been deleted');
    }
    public function adjust()
    {
        $frontJumlah = $this->update_saldo;
        $this->update_saldo = str_replace('.', '', substr($this->update_saldo, 4));
        if ($this->update_saldo == $this->rekening->saldo_sekarang) {
            $this->update_saldo = $frontJumlah;
            return $this->addError('update_saldo', 'Same Amount');
        }

        $jumlah = abs($this->rekening->saldo_sekarang - $this->update_saldo);
        $jenisuang_id = 0;
        $category_id = null;
        $category_masuk_id = null;

        if ($this->update_saldo > $this->rekening->saldo_sekarang) {
            $jenisuang_id = 1;
            $category_masuk_id = CategoryMasuk::firstWhere('nama', 'Adjustment')->id;
        } else {
            $jenisuang_id = 2;
            $category_id = Category::firstWhere('nama', 'Adjustment')->id;
        }

        Transaction::create([
            'user_id' => auth()->id(),
            'jenisuang_id' => $jenisuang_id,
            'jumlah' => $jumlah,
            'rekening_id' => $this->rekening->id,
            'keterangan' => 'Adjustment',
            'category_id' => $category_id,
            'category_masuk_id' => $category_masuk_id
        ]);

        $this->rekening->update(['saldo_sekarang' => $this->update_saldo]);
        $this->emit("hideAdjust");
        $this->emit('refreshBalance');
        $this->resetErrorBag();
        $this->update_saldo = null;
        session()->flash('success', 'Balance have been updated');
    }
    public function update()
    {
        if ($this->form['saldo_mengendap'] == '') {
            $this->form['saldo_mengendap'] = null;
        }
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
        $this->emit("hideEdit");
        $this->emit('refreshBalance');

        session()->flash('success', 'Pocket have been updated');
        $this->resetErrorBag();
    }
    public function render()
    {
        $this->jeniss = Jenis::with('user_rekenings')->get();
        return view('livewire.rekening');
    }
}
