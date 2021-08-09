<?php

namespace App\Http\Livewire\Investasi\Stock;

use App\Models\Category;
use App\Models\FinancialPlan;
use App\Models\Rekening;
use App\Models\Stock;
use App\Models\Transaction;
use Livewire\Component;

class Topup extends Component
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

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'form.rekening_id' => ['required', 'numeric', 'in:' . auth()->user()->rekenings->pluck('id')->implode(',')],
        ]);
    }

    protected $validationAttributes = [
        'form.rekening_id' => 'pocket',
    ];

    public function mount()
    {
        $this->form['kode'] = $this->stock->kode;
        // $this->form['lot'] = $this->stock->lot;
        // $this->form['harga_beli'] = 'Rp  ' . number_format($this->stock->harga_beli, 0, ',', '.');
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

        $rekening = Rekening::findOrFail($this->form['rekening_id']);
        $total = $this->form['harga_beli'] * $this->form['lot'] * 100;

        if ($total > $rekening->saldo_sekarang) {
            $this->form['harga_beli'] = $frontJumlah;
            $this->addError('form.rekening_id', 'Balance In Pocket Not Enough');
            return $this->render();
        }

        $rekening->saldo_sekarang -= $total;
        $rekening->save();

        $financialplan = FinancialPlan::findOrFail($this->stock->financial_plan_id);
        $financialplan->jumlah += $total;
        $financialplan->save();

        Transaction::create([
            'user_id' => auth()->id(),
            'jenisuang_id' => 2,
            'jumlah' => $total,
            'rekening_id' => $this->form['rekening_id'],
            'keterangan' => 'Buy Stock ' . $this->stock->kode,
            'category_id' => Category::firstWhere('nama', 'Investasi')->id,
        ]);

        $total_lot = $this->form['lot'] + $this->stock->lot;
        $avgprice = round((($this->form['harga_beli'] * $this->form['lot']) + ($this->stock->harga_beli * $this->stock->lot)) / $total_lot);
        $this->stock->update([
            'harga_beli' => $avgprice,
            'lot' => $total_lot,
            'keterangan' => $this->form['keterangan'],
            'total' => $total + $this->stock->total
        ]);
        session()->flash('success', 'TopUp Successful');
        return redirect(route('stock'));
    }
    public function render()
    {
        return view('livewire.investasi.stock.topup');
    }
}
