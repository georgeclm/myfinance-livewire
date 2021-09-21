<?php

namespace App\Http\Livewire\Investasi\Stock;

use App\Models\FinancialPlan;
use Livewire\Component;

class Change extends Component
{
    public $stock;
    public $error;
    public $form;


    public function mount()
    {
        $this->form = $this->stock->toArray();
        $this->form['harga_beli'] = 'Rp  ' . number_format($this->stock->harga_beli, 0, ',', '.');
    }
    public function rules()
    {
        return [
            'form.financial_plan_id' => ['required', 'numeric', 'in:' . auth()->user()->financialplans->pluck('id')->implode(',')]
        ];
    }
    public function submit()
    {
        $this->validate();

        $this->stock->financialplan->jumlah -= $this->stock->total;
        $this->stock->financialplan->save();

        $financialplan = FinancialPlan::findOrFail($this->form['financial_plan_id']);
        $financialplan->jumlah += $this->stock->total;
        $financialplan->save();

        $this->stock->update(['financial_plan_id' => $this->form['financial_plan_id']]);
        session()->flash('success', 'Stock have been changed');
        return redirect(route('stock'));
    }
    public function render()
    {
        return view('livewire.investasi.stock.change');
    }
}
