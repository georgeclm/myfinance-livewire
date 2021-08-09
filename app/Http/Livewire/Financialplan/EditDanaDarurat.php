<?php

namespace App\Http\Livewire\Financialplan;

use Livewire\Component;

class EditDanaDarurat extends Component
{
    public $financialplan;
    public $form = [
        'jumlah' => '',
        'status' => ''
    ];
    public $error;
    public $rules = [
        'form.jumlah' => ['required', 'numeric'],
        'form.status' => ['required', 'numeric', 'in:1,2,3']
    ];

    public function mount()
    {
        $this->form['jumlah'] = 'Rp  ' . number_format($this->financialplan->perbulan, 0, ',', '.');
        $this->form['status'] = $this->financialplan->status_pernikahan;
    }

    public function submit()
    {
        $frontJumlah = $this->form['jumlah'];
        $this->form['jumlah'] = str_replace('.', '', substr($this->form['jumlah'], 4));
        $this->validate();
        if ($this->form['jumlah'] == '0') {
            $this->form['jumlah'] = $frontJumlah;
            $this->error = 'Fund cannot be 0';
            $this->dispatchBrowserEvent('contentChanged');
            return $this->render();
        }

        $multiply =  [
            1 =>  6,
            2 =>  9,
        ][$this->form['status']] ??  12;

        $this->form['jumlah'] *= $multiply;

        $this->financialplan->update([
            'target' => $this->form['jumlah'],
            'status_pernikahan' => $this->form['status'],
            'perbulan' => $this->form['jumlah'] / $multiply
        ]);

        session()->flash('success', 'Emergency Fund Plan have been updated');
        return redirect(route('financialplan'));
    }
    public function render()
    {
        return view('livewire.financialplan.edit-dana-darurat');
    }
}
