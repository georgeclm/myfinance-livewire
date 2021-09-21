<?php

namespace App\Http\Livewire\Investasi\P2p;

use App\Models\FinancialPlan;
use Livewire\Component;

class Change extends Component
{
    public $p2p;
    public $form;

    public function mount()
    {
        $this->form = $this->p2p->toArray();
        $this->form['jumlah'] = 'Rp  ' . number_format($this->p2p->jumlah, 0, ',', '.');
        $this->form['harga_jual'] = 'Rp  ' . number_format($this->p2p->harga_jual, 0, ',', '.');
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
        $this->form['harga_jual'] = str_replace('.', '', substr($this->form['harga_jual'], 4));
        $this->validate();
        // dd($this->form);
        $this->p2p->financialplan->jumlah -= $this->p2p->jumlah;
        $this->p2p->financialplan->save();

        $financialplan = FinancialPlan::findOrFail($this->form['financial_plan_id']);
        $financialplan->jumlah += $this->p2p->jumlah;
        $financialplan->save();

        $this->p2p->update(['financial_plan_id' => $this->form['financial_plan_id']]);
        session()->flash('success', 'P2P Goal have been changed');
        return redirect(route('p2p'));
    }
    public function render()
    {
        return view('livewire.investasi.p2p.change');
    }
}
