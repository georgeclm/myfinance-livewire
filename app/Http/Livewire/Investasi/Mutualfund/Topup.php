<?php

namespace App\Http\Livewire\Investasi\Mutualfund;

use App\Models\Category;
use App\Models\FinancialPlan;
use App\Models\Rekening;
use App\Models\Transaction;
use Livewire\Component;

class Topup extends Component
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
        $this->form['rekening_id'] = $this->mutual_fund->rekening_id;
        $this->form['financial_plan_id'] = $this->mutual_fund->financial_plan_id;
        $this->form['harga_beli'] = 'Rp  ' . number_format($this->mutual_fund->harga_beli, 0, ',', '.');
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

        $rekening = Rekening::findOrFail($this->form['rekening_id']);
        $total = $this->form['harga_beli'] * $this->form['unit'];

        if ($total > $rekening->saldo_sekarang) {
            $this->form['harga_beli'] = $frontJumlah;
            $this->addError('form.rekening_id', 'Balance In Pocket Not Enough');
            return $this->render();
        }

        $rekening->saldo_sekarang -= $total;
        $rekening->save();

        $financialplan = FinancialPlan::findOrFail($this->mutual_fund->financial_plan_id);
        $financialplan->jumlah += $total;
        $financialplan->save();

        Transaction::create([
            'user_id' => auth()->id(),
            'jenisuang_id' => 2,
            'jumlah' => $total,
            'rekening_id' => $this->form['rekening_id'],
            'keterangan' => 'Buy ' . $this->mutual_fund->nama_reksadana,
            'category_id' => Category::firstWhere('nama', 'Investment')->id,
        ]);

        $total_unit = $this->form['unit'] + $this->mutual_fund->unit;
        $avgprice = round((($this->form['harga_beli'] * $this->form['unit']) + ($this->mutual_fund->harga_beli * $this->mutual_fund->unit)) / $total_unit);
        $this->mutual_fund->update([
            'harga_beli' => $avgprice,
            'unit' => $total_unit,
            'keterangan' => $this->form['keterangan'],
            'total' => $total + $this->mutual_fund->total
        ]);
        session()->flash('success', 'TopUp Successful');
        return redirect(route('mutualfund'));
    }

    public function render()
    {
        return view('livewire.investasi.mutualfund.topup');
    }
}
