<?php

namespace App\Http\Livewire\Investasi;

use App\Models\CategoryMasuk;
use App\Models\Deposito as ModelsDeposito;
use App\Models\FinancialPlan;
use App\Models\Rekening;
use App\Models\Transaction;
use Livewire\Component;

class Deposito extends Component
{
    public $deposito;
    public $form;
    protected $listeners = ['refreshDeposito'];

    public function refreshDeposito()
    {
        $this->render();
    }

    public function editModal($primaryId)
    {
        $this->deposito = ModelsDeposito::findOrFail($primaryId);
        $this->form = $this->deposito->toArray();
        $this->form['harga_jual'] = 'Rp  ' . number_format($this->deposito->harga_jual, 0, ',', '.');
        $this->form['jumlah'] = 'Rp  ' . number_format($this->deposito->jumlah, 0, ',', '.');

        $this->emit('editModal');
    }


    public function changeModal($primaryid)
    {
        $this->deposito = ModelsDeposito::findOrFail($primaryid);
        $this->form = $this->deposito->toArray();
        $this->form['jumlah'] = 'Rp  ' . number_format($this->deposito->jumlah, 0, ',', '.');

        $this->emit('adjustModal');
    }

    public function sell()
    {
        $this->form['jumlah'] = str_replace('.', '', substr($this->form['jumlah'], 4));
        $this->form['harga_jual'] = str_replace('.', '', substr($this->form['harga_jual'], 4));

        $this->validate([
            'form.harga_jual' => ['required', 'numeric'],
            'form.rekening_id' => ['required', 'numeric', 'in:' . auth()->user()->rekenings->pluck('id')->implode(',')]
        ]);
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

        $this->emit('success', 'Deposito  have been sold');

        $this->emit("hideEdit");
    }

    public function change()
    {
        $this->form['jumlah'] = str_replace('.', '', substr($this->form['jumlah'], 4));
        // $this->form['harga_jual'] = str_replace('.', '', substr($this->form['harga_jual'], 4));
        $this->validate([
            'form.financial_plan_id' => ['required', 'numeric', 'in:' . auth()->user()->financialplans->pluck('id')->implode(',')],
        ]);
        // dd($this->form);
        $this->deposito->financialplan->jumlah -= $this->deposito->jumlah;
        $this->deposito->financialplan->save();

        $financialplan = FinancialPlan::findOrFail($this->form['financial_plan_id']);
        $financialplan->jumlah += $this->deposito->jumlah;
        $financialplan->save();

        $this->deposito->update(['financial_plan_id' => $this->form['financial_plan_id']]);
        $this->emit('success', 'Deposito Goal have been changed');

        $this->emit("hideAdjust");
    }

    public function render()
    {
        return view('livewire.investasi.deposito');
    }
}
