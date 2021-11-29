<?php

namespace App\Http\Livewire\Financialplan;

use App\Models\FinancialPlan;
use Livewire\Component;

class CreateDanaMenabung extends Component
{

    public $form = [
        'target' => '',
        'jumlah' => '',
        'bulan' => ''
    ];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'form.bulan' => ['required', 'numeric', 'between:1,99'],
        ]);
    }

    protected $validationAttributes = [
        'form.bulan' => 'month',
    ];

    public $rules = [
        'form.target' => ['required', 'numeric'],
        'form.jumlah' => ['required', 'numeric'],
        'form.bulan' => ['required', 'numeric', 'between:1,99']
    ];
    public function submit()
    {
        $frontTarget = $this->form['target'];
        $this->form['target'] = str_replace('.', '', substr($this->form['target'], 4));
        $frontJumlah = $this->form['jumlah'];
        $this->form['jumlah'] = str_replace('.', '', substr($this->form['jumlah'], 4));
        $this->validate();
        if ($this->form['target'] == '0') {
            $this->form['target'] = $frontTarget;
            $this->form['jumlah'] = $frontJumlah;
            return $this->emit('error', 'Funds or how long cannot be 0');
        }

        $target = $this->form['target'] + ($this->form['jumlah'] * $this->form['bulan']);
        FinancialPlan::create([
            'user_id' => auth()->id(),
            'nama' => 'Regular Savings',
            'produk' => 'Regular Savings Fund',
            'target' => $target,
            'jumlah' => 0,
            'perbulan' => $this->form['jumlah'],
            'bulan' => $this->form['bulan'],
            'dana_awal' => $this->form['target']
        ]);
        $this->emit('success', 'Savings Fund Plan have been saved');
        $this->emit("hidemodalSaving");
        $this->emit('refreshFinancialPlan');
        $this->resetErrorBag();
        $this->form = [
            'target' => '',
            'jumlah' => '',
            'bulan' => ''
        ];
    }
    public function render()
    {
        return view('livewire.financialplan.create-dana-menabung');
    }
}
