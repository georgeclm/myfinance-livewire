<?php

namespace App\Http\Livewire\Investasi\P2p;

use App\Models\Category;
use App\Models\FinancialPlan;
use App\Models\P2P;
use App\Models\Rekening;
use App\Models\Transaction;
use Livewire\Component;

class Create extends Component
{
    public $error;
    public $form = [
        'nama_p2p' => '',
        'jumlah' => '',
        'harga_jual' => '',
        'rekening_id' => '',
        'financial_plan_id' => '',
        'keterangan' => null,
        'jatuh_tempo' => ''
    ];
    public function rules()
    {
        return [
            'form.nama_p2p' => 'required',
            'form.jumlah' => ['required', 'numeric'],
            'form.harga_jual' => ['required', 'numeric'],
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
        $frontJual = $this->form['harga_jual'];
        $this->form['harga_jual'] = str_replace('.', '', substr($this->form['harga_jual'], 4));

        $this->validate();
        if ($this->form['jumlah'] > $this->form['harga_jual']) {
            $this->form['jumlah'] = $frontJumlah;
            $this->form['harga_jual'] = $frontJual;
            $this->addError('form.harga_jual', 'Return Amount Less than First Amount');
            return $this->render();
        }

        $bunga = ($this->form['harga_jual'] * 100 / $this->form['jumlah']) - 100;
        $rekening = Rekening::findOrFail($this->form['rekening_id']);

        if ($this->form['jumlah'] > $rekening->saldo_sekarang) {
            $this->form['jumlah'] = $frontJumlah;
            $this->form['harga_jual'] = $frontJual;
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
            'keterangan' => 'Beli P2P ' . $this->form['nama_p2p'],
            'category_id' => Category::firstWhere('nama', 'Investment')->id,
        ]);

        P2P::create([
            'user_id' => auth()->id(),
            'nama_p2p' => $this->form['nama_p2p'],
            'bunga' => $bunga,
            'jumlah' => $this->form['jumlah'],
            'harga_jual' => $this->form['harga_jual'],
            'rekening_id' => $this->form['rekening_id'],
            'financial_plan_id' => $this->form['financial_plan_id'],
            'keterangan' => $this->form['keterangan'],
            'jatuh_tempo' => $this->form['jatuh_tempo'],
            'gain_or_loss' => $this->form['harga_jual'] - $this->form['jumlah'],
        ]);
        session()->flash('success', 'P2P have been saved');
        return redirect(route('p2p'));
    }
    public function render()
    {
        return view('livewire.investasi.p2p.create');
    }
}
