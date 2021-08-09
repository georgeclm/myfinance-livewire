<?php

namespace App\Http\Livewire\Financialplan;

use Livewire\Component;

class EditDanaMenabung extends Component
{
    public $financialplan;
    public $error;
    public $form = [
        'target' => '',
        'jumlah' => '',
        'bulan' => ''
    ];

    public $rules = [
        'form.target' => ['required', 'numeric'],
        'form.jumlah' => ['required', 'numeric'],
        'form.bulan' => ['required', 'numeric']
    ];


    public function mount()
    {
        $this->form['jumlah'] = 'Rp  ' . number_format($this->financialplan->perbulan, 0, ',', '.');
        $this->form['target'] = 'Rp  ' . number_format($this->financialplan->dana_awal, 0, ',', '.');
        $this->form['bulan'] = $this->financialplan->bulan;
    }

    public function submit()
    {
        $frontTarget = $this->form['target'];
        $this->form['target'] = str_replace('.', '', substr($this->form['target'], 4));
        $frontJumlah = $this->form['jumlah'];
        $this->form['jumlah'] = str_replace('.', '', substr($this->form['jumlah'], 4));
        $this->validate();
        if ($this->form['target'] == '0' || $this->form['bulan'] == '0') {
            $this->form['target'] = $frontTarget;
            $this->form['jumlah'] = $frontJumlah;
            $this->error = 'Funds or how long cannot be 0';
            $this->dispatchBrowserEvent('contentChanged');
            return $this->render();
        }

        $target = $this->form['target'] + ($this->form['jumlah'] * $this->form['bulan']);
        $this->financialplan->update([
            'target' => $target,
            'perbulan' => $this->form['jumlah'],
            'bulan' => $this->form['bulan'],
            'dana_awal' => $this->form['target']
        ]);
        session()->flash('success', 'Savings Fund Plan have been updated');
        return redirect(route('financialplan'));
    }
    public function render()
    {
        return view('livewire.financialplan.edit-dana-menabung');
    }
}
