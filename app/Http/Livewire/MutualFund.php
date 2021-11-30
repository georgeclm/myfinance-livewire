<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\CategoryMasuk;
use App\Models\FinancialPlan;
use App\Models\MutualFund as ModelsMutualFund;
use App\Models\Rekening;
use App\Models\Transaction;
use Livewire\Component;

class MutualFund extends Component
{
    public $mutual_funds;
    public $mutual_fund;
    public $form;
    public $frontJumlah;
    public $frontTotal;
    protected $listeners = ['refreshMutualFund'];

    public function refreshMutualFund()
    {
        $this->render();
    }

    public function topUpModal($primaryid)
    {
        $this->mutual_fund = ModelsMutualFund::findOrFail($primaryid);
        $this->form = $this->mutual_fund->toArray();
        $this->form['harga_beli'] = 'Rp  ' . number_format($this->mutual_fund->harga_beli, 0, ',', '.');
        $this->form['total'] = '';
        $this->emit('editModal');
        $this->emit('refresh-count', $this->form['harga_beli']);
    }

    public function create()
    {
        $this->emit('CreatePocket');
        $this->emit('refresh-count', 'Rp. 0');
    }

    public function changeModal($primaryId)
    {
        $this->mutual_fund = ModelsMutualFund::findOrFail($primaryId);
        $this->form = $this->mutual_fund->toArray();
        $this->form['harga_beli'] = 'Rp  ' . number_format($this->mutual_fund->harga_beli, 0, ',', '.');
        $this->form['total'] = 'Rp  ' . number_format($this->mutual_fund->total, 0, ',', '.');
        $this->emit('adjustModal');
    }

    public function sellModal($primaryId)
    {
        $this->mutual_fund = ModelsMutualFund::findOrFail($primaryId);
        $this->form = $this->mutual_fund->toArray();
        $this->form['harga_beli'] = 'Rp  ' . number_format($this->mutual_fund->harga_beli, 0, ',', '.');
        $this->emit('deleteModal');
    }

    public function sell()
    {
        $this->frontJumlah = $this->form['harga_beli'];
        $this->form['harga_beli'] = str_replace('.', '', substr($this->form['harga_beli'], 4));
        $this->validate([
            'form.unit' => ['required', 'numeric'],
            'form.harga_beli' => ['required', 'numeric'],
            'form.rekening_id' => ['required', 'numeric', 'in:' . auth()->user()->rekenings->pluck('id')->implode(',')],
        ]);
        if ($this->form['unit'] > $this->mutual_fund->unit) {
            $this->form['harga_beli'] = $this->frontJumlah;
            return $this->emit('error', 'Total unit More than the current');
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
        $this->emit('success', 'Mutual Fund have been sold');
        $this->emit('hideDelete');
    }

    public function change()
    {
        $this->validate([
            'form.financial_plan_id' => ['required', 'numeric', 'in:' . auth()->user()->financialplans->pluck('id')->implode(',')]
        ]);

        $this->mutual_fund->financialplan->jumlah -= $this->mutual_fund->total;
        $this->mutual_fund->financialplan->save();

        $financialplan = FinancialPlan::findOrFail($this->form['financial_plan_id']);
        $financialplan->jumlah += $this->mutual_fund->total;
        $financialplan->save();

        $this->mutual_fund->update(['financial_plan_id' => $this->form['financial_plan_id']]);
        $this->emit('success', 'Goal have been changed');
        $this->emit('hideAdjust');
    }

    public function topUp()
    {
        $this->frontJumlah = $this->form['harga_beli'];
        $this->form['harga_beli'] = str_replace('.', '', substr($this->form['harga_beli'], 4));
        $this->frontTotal = $this->form['total'];
        $this->form['total'] = str_replace('.', '', substr($this->form['total'], 4));
        $this->form['unit'] = round($this->form['total'] / $this->form['harga_beli'], 4);
        $this->validate([
            'form.unit' => ['required', 'numeric'],
            'form.harga_beli' => ['required', 'numeric'],
            'form.rekening_id' => ['required', 'numeric', 'in:' . auth()->user()->rekenings->pluck('id')->implode(',')],
        ]);

        $rekening = Rekening::findOrFail($this->form['rekening_id']);

        if ($this->form['total'] > $rekening->saldo_sekarang) {
            $this->form['harga_beli'] = $this->frontJumlah;
            $this->form['total'] = $this->frontTotal;
            return $this->emit('error', 'Balance In Pocket Not Enough');
        }

        $rekening->saldo_sekarang -= $this->form['total'];
        $rekening->save();

        $financialplan = FinancialPlan::findOrFail($this->mutual_fund->financial_plan_id);
        $financialplan->jumlah += $this->form['total'];
        $financialplan->save();

        Transaction::create([
            'user_id' => auth()->id(),
            'jenisuang_id' => 2,
            'jumlah' => $this->form['total'],
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
            'total' => $this->form['total'] + $this->mutual_fund->total
        ]);
        $this->emit('success', 'TopUp Successful');
        $this->emit('hideEdit');
    }

    public function render()
    {
        if ($this->getErrorBag()->messages() != []) {
            $this->form['harga_beli'] = $this->frontJumlah;
            $this->form['total'] = $this->frontTotal;
        }
        $this->mutual_funds = ModelsMutualFund::where('user_id', auth()->id())->where('unit', '!=', 0)->latest()->get();

        return view('livewire.mutual-fund');
    }
}
