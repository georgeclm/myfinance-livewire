<?php

namespace App\Http\Livewire\Financialplan;

use App\Models\FinancialPlan;
use Livewire\Component;

class CreateDanaMembeliBarang extends Component
{

    public $form = [
        'nama' => '',
        'target' => '',
        'bulan' => '',
        'jumlah' => ''
    ];
    public $rules = [
        'form.nama' => 'required',
        'form.target' => ['required', 'numeric'],
        'form.bulan' => ['required', 'numeric', 'between:1,99'],
        'form.jumlah' => ['required', 'numeric']
    ];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'form.nama' => 'required',
            'form.bulan' => ['required', 'numeric', 'between:1,99'],
        ]);
    }

    protected $validationAttributes = [
        'form.nama' => 'name',
        'form.bulan' => 'month',
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
            return $this->emit('error', 'Stuff Price cannot be 0');
        }
        $target = $this->form['target'] - $this->form['jumlah'];
        $perbulan = $target / $this->form['bulan'];

        FinancialPlan::create([
            'user_id' => auth()->id(),
            'nama' => $this->form['nama'],
            'produk' => 'Fund For Stuff',
            'target' => $target,
            'jumlah' => 0,
            'perbulan' => $perbulan,
            'bulan' => $this->form['bulan'],
            'dana_awal' => $this->form['jumlah']
        ]);
        $this->emit('success', 'Fund For Stuff Plan have been saved');
        $this->emit("hidemodalFund");
        $this->emit('refreshFinancialPlan');
        $this->resetErrorBag();
        $this->form = [
            'nama' => '',
            'target' => '',
            'bulan' => '',
            'jumlah' => ''
        ];
    }
    public function render()
    {
        return view('livewire.financialplan.create-dana-membeli-barang');
    }
}
