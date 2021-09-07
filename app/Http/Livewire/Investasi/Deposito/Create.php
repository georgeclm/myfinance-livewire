<?php

namespace App\Http\Livewire\Investasi\Deposito;

use App\Models\Category;
use App\Models\Deposito;
use App\Models\FinancialPlan;
use App\Models\Rekening;
use App\Models\Transaction;
use Livewire\Component;

class Create extends Component
{
    public $error;
    public $form = [
        'nama_bank' => '',
        'nama_deposito' => '',
        'jumlah' => '',
        'bunga' => '',
        'rekening_id' => '',
        'financial_plan_id' => '',
        'keterangan' => null,
        'jatuh_tempo' => ''
    ];

    public function rules()
    {
        return [
            'form.nama_bank' => 'required',
            'form.nama_deposito' => 'required',
            'form.jumlah' => ['required', 'numeric'],
            'form.bunga' => ['required', 'numeric'],
            'form.rekening_id' => ['required', 'numeric', 'in:' . auth()->user()->rekenings->pluck('id')->implode(',')],
            'form.financial_plan_id' => ['required', 'numeric', 'in:' . auth()->user()->financialplans->pluck('id')->implode(',')],
            'form.keterangan' => 'nullable',
            'form.jatuh_tempo' => 'required'
        ];
    }

    public function submit()
    {
        $frontJumlah = $this->form['jumlah'];
        $this->form['jumlah'] = str_replace('.', '', substr($this->form['jumlah'], 4));
        // $frontJual = $this->form['harga_jual'];
        // $this->form['harga_jual'] = str_replace('.', '', substr($this->form['harga_jual'], 4));
        $this->validate();


        // $bunga = ($this->form['harga_jual'] * 100 / $this->form['jumlah']) - 100;
        $rekening = Rekening::findOrFail($this->form['rekening_id']);

        if ($this->form['jumlah'] > $rekening->saldo_sekarang) {
            $this->form['jumlah'] = $frontJumlah;
            $this->addError('form.rekening_id', 'Balance Not Enough');
            return $this->render();
        }

        $rekening->saldo_sekarang -= $this->form['jumlah'];
        $rekening->save();

        $financialplan = FinancialPlan::findOrFail($this->form['financial_plan_id']);
        $financialplan->jumlah += $this->form['jumlah'];
        $financialplan->save();

        Transaction::create([
            'user_id' => auth()->id(),
            'jenisuang_id' => 2,
            'jumlah' => $this->form['jumlah'],
            'rekening_id' => $this->form['rekening_id'],
            'keterangan' => 'Buy ' . $this->form['nama_deposito'],
            'category_id' => Category::firstWhere('nama', 'Investment')->id,
        ]);

        Deposito::create([
            'user_id' => auth()->id(),
            'nama_deposito' => $this->form['nama_deposito'],
            'nama_bank' => $this->form['nama_bank'],
            'bunga' => $this->form['bunga'],
            'harga_jual' => $this->form['jumlah'] * (100 + $this->form['bunga']) / 100,
            'jumlah' => $this->form['jumlah'],
            'rekening_id' => $this->form['rekening_id'],
            'financial_plan_id' => $this->form['financial_plan_id'],
            'keterangan' => $this->form['keterangan'],
            'jatuh_tempo' => $this->form['jatuh_tempo'],
        ]);
        session()->flash('success', 'Deposito have been saved');
        return redirect(route('deposito'));
    }

    public function render()
    {
        return view('livewire.investasi.deposito.create');
    }
}
