<?php

namespace App\Http\Livewire\Investasi\Mutualfund;

use App\Models\FinancialPlan;
use Livewire\Component;

class Change extends Component
{
    public $mutual_fund;
    public $error;
    public $form;
    public function rules()
    {
        return [
            'form.financial_plan_id' => ['required', 'numeric', 'in:' . auth()->user()->financialplans->pluck('id')->implode(',')]
        ];
    }
    public function mount()
    {
        $this->form = $this->mutual_fund->toArray();
        $this->form['harga_beli'] = 'Rp  ' . number_format($this->mutual_fund->harga_beli, 0, ',', '.');
    }
    public function submit()
    {
        $this->validate();

        $this->mutual_fund->financialplan->jumlah -= $this->mutual_fund->total;
        $this->mutual_fund->financialplan->save();

        $financialplan = FinancialPlan::findOrFail($this->form['financial_plan_id']);
        $financialplan->jumlah += $this->mutual_fund->total;
        $financialplan->save();

        $this->mutual_fund->update(['financial_plan_id' => $this->form['financial_plan_id']]);
        session()->flash('success', 'Goal have been changed');
        return redirect(route('mutualfund'));
    }
    public function render()
    {
        return view('livewire.investasi.mutualfund.change');
    }
}
