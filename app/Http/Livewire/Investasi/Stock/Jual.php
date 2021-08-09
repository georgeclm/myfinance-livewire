<?php

namespace App\Http\Livewire\Investasi\Stock;

use App\Models\CategoryMasuk;
use App\Models\Rekening;
use App\Models\Transaction;
use Livewire\Component;

class Jual extends Component
{
    public $stock;
    public $error;
    public $form = [
        'kode' => '',
        'lot' => '',
        'harga_beli' => '',
        'biaya_lain' => null,
        'rekening_id' => '',
        'financial_plan_id' => '',
        'keterangan' => null
    ];


    public function mount()
    {
        $this->form['kode'] = $this->stock->kode;
        $this->form['lot'] = $this->stock->lot;
        $this->form['harga_beli'] = 'Rp  ' . number_format($this->stock->harga_beli, 0, ',', '.');
        $this->form['rekening_id'] = $this->stock->rekening_id;
        $this->form['financial_plan_id'] = $this->stock->financial_plan_id;
    }



    public function rules()
    {
        return [
            'form.lot' => ['required', 'numeric'],
            'form.harga_beli' => ['required', 'numeric'],
            'form.rekening_id' => ['required', 'numeric', 'in:' . auth()->user()->rekenings->pluck('id')->implode(',')],
        ];
    }
    public function submit()
    {
        $frontJumlah = $this->form['harga_beli'];
        $this->form['harga_beli'] = str_replace('.', '', substr($this->form['harga_beli'], 4));
        $this->validate();

        if ($this->form['lot'] > $this->stock->lot) {
            $this->form['harga_beli'] = $frontJumlah;
            $this->error = 'Total Lot More than the limit';
            $this->dispatchBrowserEvent('contentChanged');
            return $this->render();
        }

        $total_jual = $this->form['harga_beli'] * $this->form['lot'] * 100;

        $rekening = Rekening::findOrFail($this->form['rekening_id']);
        $rekening->saldo_sekarang += $total_jual;
        $rekening->save();

        $total_beli = $this->stock->harga_beli * $this->form['lot'] * 100;
        $this->stock->financialplan->jumlah -= $total_beli;
        $this->stock->financialplan->save();

        $this->stock->harga_jual = $this->form['harga_beli'];
        $this->stock->lot -= $this->form['lot'];
        $this->stock->total = $this->stock->lot * 100 * $this->stock->harga_beli;
        $this->stock->gain_or_loss += $total_jual - $total_beli;
        $this->stock->save();
        if ($this->stock->lot == 0) {
            $this->stock->delete();
        }
        Transaction::create([
            'user_id' => auth()->id(),
            'jenisuang_id' => 1,
            'jumlah' => $total_jual,
            'rekening_id' => $this->form['rekening_id'],
            'keterangan' => 'Sell Stock ' . $this->stock->kode,
            'category_masuk_id' => CategoryMasuk::firstWhere('nama', 'Jual Investasi')->id,
        ]);
        session()->flash('success', 'Stock have been sold');
        return redirect(route('stock'));
    }

    public function render()
    {
        return view('livewire.investasi.stock.jual');
    }
}
