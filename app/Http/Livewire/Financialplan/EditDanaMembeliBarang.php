<?php

namespace App\Http\Livewire\Financialplan;

use Livewire\Component;

class EditDanaMembeliBarang extends Component
{
    public $financialplan;
    public $form = [
        'nama' => '',
        'target' => '',
        'bulan' => '',
        'jumlah' => ''
    ];
    public $error;
    public $rules = [
        'form.nama' => 'required',
        'form.target' => ['required', 'numeric'],
        'form.bulan' => ['required', 'numeric'],
        'form.jumlah' => ['required', 'numeric']
    ];

    public function mount()
    {
        $this->form['jumlah'] = 'Rp  ' . number_format($this->financialplan->dana_awal, 0, ',', '.');
        $this->form['nama'] = $this->financialplan->nama;
        $this->form['target'] = 'Rp  ' . number_format($this->financialplan->target + $this->financialplan->dana_awal, 0, ',', '.');
        $this->form['bulan'] = $this->financialplan->bulan;
    }

    public function submit()
    {
        $frontTarget = $this->form['target'];
        $this->form['target'] = str_replace('.', '', substr($this->form['target'], 4));
        $frontJumlah = $this->form['jumlah'];
        $this->form['jumlah'] = str_replace('.', '', substr($this->form['jumlah'], 4));
        $this->validate();
        // dd($this->form);

        if ($this->form['target'] == '0' || $this->form['bulan'] == '0') {
            $this->form['target'] = $frontTarget;
            $this->form['jumlah'] = $frontJumlah;
            $this->error = 'Stuff Price or how long cannot be 0';
            $this->dispatchBrowserEvent('contentChanged');
            return $this->render();
        }
        $target = $this->form['target'] - $this->form['jumlah'];
        $perbulan = $target / $this->form['bulan'];

        $this->financialplan->update([
            'nama' => $this->form['nama'],
            'target' => $target,
            'perbulan' => $perbulan,
            'bulan' => $this->form['bulan'],
            'dana_awal' => $this->form['jumlah']
        ]);
        session()->flash('success', 'Fund For Stuff Plan have been updated');
        return redirect(route('financialplan'));
    }

    public function render()
    {
        return view('livewire.financialplan.edit-dana-membeli-barang');
    }
}
