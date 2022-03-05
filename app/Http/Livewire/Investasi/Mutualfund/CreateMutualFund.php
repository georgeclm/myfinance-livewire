<?php

namespace App\Http\Livewire\Investasi\Mutualfund;

use App\Models\Category;
use App\Models\FinancialPlan;
use App\Models\MutualFund;
use App\Models\Rekening;
use App\Models\Transaction;
use Livewire\Component;

class CreateMutualFund extends Component
{
    public $error;
    public $form = [
        'nama_reksadana' => '',
        'unit' => '',
        'harga_beli' => '',
        'rekening_id' => '',
        'financial_plan_id' => '',
        'keterangan' => null,
        'total' => ''
    ];
    public function rules()
    {
        return [
            'form.nama_reksadana' => 'required',
            'form.keterangan' => 'nullable',
            'form.unit' => ['required', 'numeric'],
            'form.harga_beli' => ['required', 'numeric'],
            'form.rekening_id' => ['required', 'numeric', 'in:' . auth()->user()->rekenings->pluck('id')->implode(',')],
            'form.financial_plan_id' => ['required', 'numeric', 'in:' . auth()->user()->financialplans->pluck('id')->implode(',')],
        ];
    }
    public function submit()
    {
        $frontJumlah = $this->form['harga_beli'];
        $this->form['harga_beli'] = str_replace('.', '', substr($this->form['harga_beli'], 4));
        $frontTotal = $this->form['total'];
        $this->form['total'] = str_replace('.', '', substr($this->form['total'], 4));
        $this->form['unit'] = round($this->form['total'] / $this->form['harga_beli'], 4);

        $this->validate();
        // dd($this->form);
        $rekening = Rekening::findOrFail($this->form['rekening_id']);
        if ($this->form['total'] > $rekening->saldo_sekarang) {
            $this->form['harga_beli'] = $frontJumlah;
            $this->form['total'] = $frontTotal;
            return $this->emit('success', 'Balance In Pocket Not Enough ');
        }

        $rekening->saldo_sekarang -= $this->form['total'];
        $rekening->save();

        $financialplan = FinancialPlan::findOrFail($this->form['financial_plan_id']);
        $financialplan->jumlah += $this->form['total'];
        $financialplan->save();
        Transaction::create([
            'user_id' => auth()->id(),
            'jenisuang_id' => 2,
            'jumlah' => $this->form['total'],
            'rekening_id' => $this->form['rekening_id'],
            'keterangan' => 'Buy ' . $this->form['nama_reksadana'],
            'category_id' => Category::firstWhere('nama', 'Investment')->id,
        ]);
        MutualFund::create($this->form + ['user_id' => auth()->id()]);
        $this->emit('success', 'Mutual Fund have been saved');
        $this->emit('hideCreatePocket');
        $this->emit('refreshMutualFund');
        $this->form = [
            'nama_reksadana' => '',
            'unit' => '',
            'harga_beli' => '',
            'rekening_id' => '',
            'financial_plan_id' => '',
            'keterangan' => null,
            'total' => ''
        ];
    }
    public function render()
    {
        $this->emit('refresh-count', 'Rp. 0');
        $this->emit('refresh-mutual-fund');

        return view('livewire.investasi.mutualfund.create-mutual-fund');
    }
}
