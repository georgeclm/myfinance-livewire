<?php

namespace App\Http\Livewire\Investasi\P2p;

use App\Models\CategoryMasuk;
use App\Models\Rekening;
use App\Models\Transaction;
use Livewire\Component;

class Sell extends Component
{
    public $p2p;
    public $form = [
        'nama_p2p' => '',
        'jumlah' => '',
        'harga_jual' => '',
        'rekening_id' => '',
        'financial_plan_id' => '',
        'keterangan' => null,
        'jatuh_tempo' => ''
    ];
    public function mount()
    {
        $this->form['nama_p2p'] = $this->p2p->nama_p2p;
        $this->form['jumlah'] = 'Rp  ' . number_format($this->p2p->jumlah, 0, ',', '.');
        $this->form['harga_jual'] = 'Rp  ' . number_format($this->p2p->harga_jual, 0, ',', '.');
        $this->form['rekening_id'] = $this->p2p->rekening_id;
        $this->form['financial_plan_id'] = $this->p2p->financial_plan_id;
        $this->form['keterangan'] = $this->p2p->keterangan;
        $this->form['jatuh_tempo'] = $this->p2p->jatuh_tempo;
    }

    public function rules()
    {
        return [
            'form.harga_jual' => ['required', 'numeric'],
            'form.rekening_id' => ['required', 'numeric', 'in:' . auth()->user()->rekenings->pluck('id')->implode(',')]
        ];
    }
    public function submit()
    {
        $this->form['jumlah'] = str_replace('.', '', substr($this->form['jumlah'], 4));
        $this->form['harga_jual'] = str_replace('.', '', substr($this->form['harga_jual'], 4));

        $this->validate();
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

        session()->flash('success', 'P2P  have been sold');
        return redirect(route('p2p'));
    }
    public function render()
    {
        return view('livewire.investasi.p2p.sell');
    }
}
