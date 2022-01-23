<?php

namespace App\Http\Livewire\Investasi;

use App\Models\CategoryMasuk;
use App\Models\FinancialPlan;
use App\Models\P2P as ModelsP2P;
use App\Models\Rekening;
use App\Models\Transaction;
use Livewire\Component;

class P2p extends Component
{

    public $p2p;
    public $form;
    public $frontJumlah;
    public $frontJual;
    protected $listeners = ['refreshP2P'];

    public function refreshP2P()
    {
        $this->render();
    }

    public function changeModal($primaryId)
    {
        $this->p2p = ModelsP2P::findOrFail($primaryId);
        $this->form = $this->p2p->toArray();
        $this->form['jumlah'] = 'Rp  ' . number_format($this->p2p->jumlah, 0, ',', '.');
        $this->form['harga_jual'] = 'Rp  ' . number_format($this->p2p->harga_jual, 0, ',', '.');
        $this->emit('editModal');
    }

    public function sellModal($primaryId)
    {
        $this->p2p = ModelsP2P::findOrFail($primaryId);
        $this->form = $this->p2p->toArray();
        $this->form['jumlah'] = 'Rp  ' . number_format($this->p2p->jumlah, 0, ',', '.');
        $this->form['harga_jual'] = 'Rp  ' . number_format($this->p2p->harga_jual, 0, ',', '.');
        $this->emit('deleteModal');
    }

    public function sell()
    {
        $this->frontJumlah = $this->form['jumlah'];
        $this->frontJual = $this->form['harga_jual'];
        $this->form['jumlah'] = convert_to_number($this->form['jumlah']);
        $this->form['harga_jual'] = str_replace('.', '', substr($this->form['harga_jual'], 4));

        $this->validate([
            'form.harga_jual' => ['required', 'numeric'],
            'form.rekening_id' => ['required', 'numeric', 'in:' . auth()->user()->rekenings->pluck('id')->implode(',')]
        ]);
        $rekening = Rekening::findOrFail($this->form['rekening_id']);
        $rekening->saldo_sekarang += $this->form['harga_jual'];
        $rekening->save();

        $this->p2p->financialplan->jumlah -= $this->form['jumlah'];
        $this->p2p->financialplan->save();

        Transaction::create([
            'user_id' => auth()->id(),
            'jenisuang_id' => 1,
            'jumlah' => $this->form['harga_jual'],
            'rekening_id' => $this->form['rekening_id'],
            'keterangan' => 'Sell P2P ' . $this->p2p->nama_p2p,
            'category_masuk_id' => CategoryMasuk::firstWhere('nama', 'Sell Investment')->id,
        ]);
        $this->p2p->delete();

        $this->emit('hideDelete');
        $this->emit('success', 'P2P  have been sold');
    }

    public function change()
    {
        $this->frontJumlah = $this->form['jumlah'];
        $this->frontJual = $this->form['harga_jual'];
        $this->form['jumlah'] = convert_to_number($this->form['jumlah']);
        $this->form['harga_jual'] = str_replace('.', '', substr($this->form['harga_jual'], 4));
        $this->validate([
            'form.financial_plan_id' => ['required', 'numeric', 'in:' . auth()->user()->financialplans->pluck('id')->implode(',')],
        ]);
        // dd($this->form);
        $this->p2p->financialplan->jumlah -= $this->p2p->jumlah;
        $this->p2p->financialplan->save();

        $financialplan = FinancialPlan::findOrFail($this->form['financial_plan_id']);
        $financialplan->jumlah += $this->p2p->jumlah;
        $financialplan->save();

        $this->p2p->update(['financial_plan_id' => $this->form['financial_plan_id']]);
        $this->emit('hideEdit');
        $this->emit('success', 'P2P Goal have been changed');
    }

    public function render()
    {
        if ($this->getErrorBag()->messages() != []) {
            $this->form['jumlah'] = $this->frontJumlah;
            $this->form['harga_jual'] = $this->frontJual;
        }
        return view('livewire.investasi.p2p');
    }
}
