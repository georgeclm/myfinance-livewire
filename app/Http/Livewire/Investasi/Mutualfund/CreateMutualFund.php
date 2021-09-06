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
        'keterangan' => null
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
        // dd($this->form);
        $frontJumlah = $this->form['harga_beli'];
        $this->form['harga_beli'] = str_replace('.', '', substr($this->form['harga_beli'], 4));
        $this->validate();
        $total = $this->form['harga_beli'] * $this->form['unit'];
        $rekening = Rekening::findOrFail($this->form['rekening_id']);
        if ($total > $rekening->saldo_sekarang) {
            $this->form['harga_beli'] = $frontJumlah;
            $this->addError('form.rekening_id', 'Balance In Pocket Not Enough ');
            return $this->render();
        }

        $rekening->saldo_sekarang -= $total;
        $rekening->save();

        $financialplan = FinancialPlan::findOrFail($this->form['financial_plan_id']);
        $financialplan->jumlah += $total;
        $financialplan->save();
        Transaction::create([
            'user_id' => auth()->id(),
            'jenisuang_id' => 2,
            'jumlah' => $total,
            'rekening_id' => $this->form['rekening_id'],
            'keterangan' => 'Buy ' . $this->form['nama_reksadana'],
            'category_id' => Category::firstWhere('nama', 'Investment')->id,
        ]);
        MutualFund::create([
            'user_id' => auth()->id(),
            'nama_reksadana' => $this->form['nama_reksadana'],
            'unit' => $this->form['unit'],
            'harga_beli' => $this->form['harga_beli'],
            'rekening_id' => $this->form['rekening_id'],
            'financial_plan_id' => $this->form['financial_plan_id'],
            'keterangan' => $this->form['keterangan'],
            'total' => $total
        ]);

        session()->flash('success', 'Mutual Fund have been saved');
        return redirect(route('mutualfund'));
    }
    public function render()
    {
        return view('livewire.investasi.mutualfund.create-mutual-fund');
    }
}
