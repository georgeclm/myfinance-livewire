<?php

namespace App\Http\Livewire\Investasi\Deposito;

use App\Models\CategoryMasuk;
use App\Models\Rekening;
use App\Models\Transaction;
use Livewire\Component;

class Sell extends Component
{
    public $deposito;
    public $form;
    public function mount()
    {
        $this->form = $this->deposito->toArray();
        $this->form['harga_jual'] = 'Rp  ' . number_format($this->deposito->harga_jual, 0, ',', '.');
        $this->form['jumlah'] = 'Rp  ' . number_format($this->deposito->jumlah, 0, ',', '.');
    }
    public function rules()
    {
        return [
            'form.harga_jual' => ['required', 'numeric'],
            'form.rekening_id' => ['required', 'numeric', 'in:' . auth()->user()->rekenings->pluck('id')->implode(',')]
        ];
    }
    public function submit()
    {
        $this->form['jumlah'] = str_replace('.', '', substr($this->form['jumlah'], 4));
        $this->form['harga_jual'] = str_replace('.', '', substr($this->form['harga_jual'], 4));

        $this->validate();
        $rekening = Rekening::findOrFail($this->form['rekening_id']);
        $rekening->saldo_sekarang += $this->form['harga_jual'];
        $rekening->save();

        $this->deposito->financialplan->jumlah -= $this->form['jumlah'];
        $this->deposito->financialplan->save();
        $this->deposito->gain_or_loss = $this->form['harga_jual'] - $this->form['jumlah'];
        $this->deposito->save();


        Transaction::create([
            'user_id' => auth()->id(),
            'jenisuang_id' => 1,
            'jumlah' => $this->form['harga_jual'],
            'rekening_id' => $this->form['rekening_id'],
            'keterangan' => 'Sell Deposito ' . $this->deposito->nama_deposito,
            'category_masuk_id' => CategoryMasuk::firstWhere('nama', 'Sell Investment')->id,
        ]);
        $this->deposito->delete();

        session()->flash('success', 'Deposito  have been sold');
        return redirect(route('deposito'));
    }
    public function render()
    {
        return view('livewire.investasi.deposito.sell');
    }
}
