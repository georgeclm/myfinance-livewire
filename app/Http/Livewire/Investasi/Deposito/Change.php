<?php

namespace App\Http\Livewire\Investasi\Deposito;

use App\Models\FinancialPlan;
use Livewire\Component;

class Change extends Component
{
    public $deposito;
    public $form = [
        'nama_bank' => '',
        'nama_deposito' => '',
        'jumlah' => '',
        'bunga' => '',
        'rekening_id' => '',
        'financial_plan_id' => '',
        'keterangan' => null,
        'jatuh_tempo' => ''
    ];
    public function mount()
    {
        $this->form['nama_bank'] = $this->deposito->nama_bank;
        $this->form['nama_deposito'] = $this->deposito->nama_deposito;
        $this->form['bunga'] = $this->deposito->bunga;
        $this->form['jumlah'] = 'Rp  ' . number_format($this->deposito->jumlah, 0, ',', '.');
        $this->form['rekening_id'] = $this->deposito->rekening_id;
        $this->form['financial_plan_id'] = $this->deposito->financial_plan_id;
        $this->form['keterangan'] = $this->deposito->keterangan;
        $this->form['jatuh_tempo'] = $this->deposito->jatuh_tempo;
    }
    public function rules()
    {
        return [
            'form.financial_plan_id' => ['required', 'numeric', 'in:' . auth()->user()->financialplans->pluck('id')->implode(',')],
        ];
    }

    public function submit()
    {
        $this->form['jumlah'] = str_replace('.', '', substr($this->form['jumlah'], 4));
        // $this->form['harga_jual'] = str_replace('.', '', substr($this->form['harga_jual'], 4));
        $this->validate();
        // dd($this->form);
        $this->deposito->financialplan->jumlah -= $this->deposito->jumlah;
        $this->deposito->financialplan->save();

        $financialplan = FinancialPlan::findOrFail($this->form['financial_plan_id']);
        $financialplan->jumlah += $this->deposito->jumlah;
        $financialplan->save();

        $this->deposito->update(['financial_plan_id' => $this->form['financial_plan_id']]);
        session()->flash('success', 'Deposito Goal have been changed');
        return redirect(route('deposito'));
    }
    public function render()
    {
        return view('livewire.investasi.deposito.change');
    }
}
