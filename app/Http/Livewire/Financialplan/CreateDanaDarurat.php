<?php

namespace App\Http\Livewire\Financialplan;

use App\Models\FinancialPlan;
use Livewire\Component;

class CreateDanaDarurat extends Component
{

    public $form = [
        'jumlah' => '',
        'status' => ''
    ];

    public $rules = [
        'form.jumlah' => ['required', 'numeric'],
        'form.status' => ['required', 'numeric', 'in:1,2,3']
    ];
    public function submit()
    {
        $frontJumlah = $this->form['jumlah'];
        $this->form['jumlah'] = str_replace('.', '', substr($this->form['jumlah'], 4));
        $this->validate();
        if ($this->form['jumlah'] == '0') {
            $this->form['jumlah'] = $frontJumlah;
            return $this->emit('error', 'Fund cannot be 0');
        }

        $multiply =  [
            1 =>  6,
            2 =>  9,
        ][$this->form['status']] ??  12;

        $this->form['jumlah'] *= $multiply;
        FinancialPlan::create([
            'user_id' => auth()->id(),
            'nama' => 'Emergency Fund',
            'produk' => 'Emergency Fund',
            'target' => $this->form['jumlah'],
            'jumlah' => 0,
            'status_pernikahan' => $this->form['status'],
            'perbulan' => $this->form['jumlah'] / $multiply
        ]);
        $this->emit('success', 'Emergency Fund Plan have been saved');
        $this->emit("hidemodalEmergency");
        $this->emit('refreshFinancialPlan');
        $this->resetErrorBag();
        $this->form = [
            'jumlah' => '',
            'status' => ''
        ];
        return redirect(route('financialplan'));
    }
    public function render()
    {
        return view('livewire.financialplan.create-dana-darurat');
    }
}
