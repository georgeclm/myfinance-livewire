<?php

namespace App\Http\Livewire\Investasi\Mutualfund;

use App\Models\CategoryMasuk;
use App\Models\Rekening;
use App\Models\Transaction;
use Livewire\Component;

class Jual extends Component
{
    public $mutual_fund;
    public $error;
    public $form = [
        'nama_reksadana' => '',
        'unit' => '',
        'harga_beli' => '',
        'biaya_lain' => null,
        'rekening_id' => '',
        'financial_plan_id' => '',
        'keterangan' => null
    ];
    public function mount()
    {
        $this->form['nama_reksadana'] = $this->mutual_fund->nama_reksadana;
        $this->form['unit'] = $this->mutual_fund->unit;
        $this->form['harga_beli'] = 'Rp  ' . number_format($this->mutual_fund->harga_beli, 0, ',', '.');
        $this->form['rekening_id'] = $this->mutual_fund->rekening_id;
        $this->form['financial_plan_id'] = $this->mutual_fund->financial_plan_id;
    }

    public function rules()
    {
        return [
            'form.unit' => ['required', 'numeric'],
            'form.harga_beli' => ['required', 'numeric'],
            'form.rekening_id' => ['required', 'numeric', 'in:' . auth()->user()->rekenings->pluck('id')->implode(',')],
        ];
    }

    public function submit()
    {
        $frontJumlah = $this->form['harga_beli'];
        $this->form['harga_beli'] = str_replace('.', '', substr($this->form['harga_beli'], 4));
        $this->validate();

        if ($this->form['unit'] > $this->mutual_fund->unit) {
            $this->form['harga_beli'] = $frontJumlah;
            $this->addError('form.unit', 'Total unit More than the current');
            return $this->render();
        }

        $total_jual = $this->form['harga_beli'] * $this->form['unit'];

        $rekening = Rekening::findOrFail($this->form['rekening_id']);
        $rekening->saldo_sekarang += $total_jual;
        $rekening->save();

        $total_beli = $this->mutual_fund->harga_beli * $this->form['unit'];
        $this->mutual_fund->financialplan->jumlah -= $total_beli;
        $this->mutual_fund->financialplan->save();

        $this->mutual_fund->harga_jual = $this->form['harga_beli'];
        $this->mutual_fund->unit -= $this->form['unit'];
        $this->mutual_fund->total = $this->mutual_fund->unit  * $this->mutual_fund->harga_beli;
        $this->mutual_fund->gain_or_loss += $total_jual - $total_beli;
        $this->mutual_fund->save();
        if ($this->mutual_fund->unit == 0) {
            $this->mutual_fund->delete();
        }
        Transaction::create([
            'user_id' => auth()->id(),
            'jenisuang_id' => 1,
            'jumlah' => $total_jual,
            'rekening_id' => $this->form['rekening_id'],
            'keterangan' => 'Sell ' . $this->mutual_fund->nama_reksadana,
            'category_masuk_id' => CategoryMasuk::firstWhere('nama', 'Sell Investment')->id,
        ]);
        session()->flash('success', 'Mutual Fund have been sold');
        return redirect(route('mutualfund'));
    }

    public function render()
    {
        return view('livewire.investasi.mutualfund.jual');
    }
}
