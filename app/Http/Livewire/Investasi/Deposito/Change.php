<?php

namespace App\Http\Livewire\Investasi\Deposito;

use App\Models\FinancialPlan;
use Livewire\Component;

class Change extends Component
{
    public $deposito;
    public $form;
    public function mount()
    {
        $this->form = $this->deposito->toArray();
        $this->form['jumlah'] = 'Rp  ' . number_format($this->deposito->jumlah, 0, ',', '.');
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
