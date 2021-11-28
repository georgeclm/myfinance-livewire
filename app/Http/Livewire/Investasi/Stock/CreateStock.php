<?php

namespace App\Http\Livewire\Investasi\Stock;

use App\Models\Category;
use App\Models\FinancialPlan;
use App\Models\Rekening;
use App\Models\Stock;
use App\Models\Transaction;
use Livewire\Component;

class CreateStock extends Component
{

    public $error;
    public $form = [
        'kode' => '',
        'lot' => '',
        'harga_beli' => '',
        'biaya_lain' => null,
        'rekening_id' => '',
        'financial_plan_id' => '',
        'keterangan' => null,
        'total' => ''
    ];



    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'form.kode' => 'required',
            'form.lot' => ['required', 'numeric'],
            'form.rekening_id' => ['required', 'numeric', 'in:' . auth()->user()->rekenings->pluck('id')->implode(',')],
            'form.financial_plan_id' => ['required', 'numeric', 'in:' . auth()->user()->financialplans->pluck('id')->implode(',') . ',0'],
        ]);
        if ($propertyName == 'form.kode') {
            $ch = curl_init();
            $code = $this->form['kode'];
            curl_setopt($ch, CURLOPT_URL, "https://yfapi.net/v6/finance/quote?symbols=$code.jk");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


            $headers = array();
            $headers[] = 'Accept: application/json';
            $headers[] = 'X-Api-Key: XE6XBRrsIR2TJRK4UVUjhaY739kIFSD24TMxFRcl';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                $this->error = 'Error Code Search';
                $this->dispatchBrowserEvent('contentChanged');
            }
            curl_close($ch);
            // dd(json_decode($result)->quoteResponse->result[0]);
            $this->form['harga_beli'] = 'Rp  ' . number_format(json_decode($result)->quoteResponse->result[0]->regularMarketPrice, 0, ',', '.');
        }
    }

    protected $validationAttributes = [
        'form.kode' => 'code',
        'form.lot' => 'lot',
        'form.rekening_id' => 'pocket',
        'form.financial_plan_id' => 'financial plan',
    ];

    public function rules()
    {
        return [
            'form.kode' => 'required',
            'form.keterangan' => 'nullable',
            'form.lot' => ['required', 'numeric'],
            'form.harga_beli' => ['required', 'numeric'],
            'form.biaya_lain' => ['nullable', 'numeric'],
            'form.rekening_id' => ['required', 'numeric', 'in:' . auth()->user()->rekenings->pluck('id')->implode(',')],
            'form.financial_plan_id' => ['required', 'numeric', 'in:' . auth()->user()->financialplans->pluck('id')->implode(',') . ',0'],
        ];
    }
    public function submit()
    {
        $frontJumlah = $this->form['harga_beli'];
        $this->form['harga_beli'] = str_replace('.', '', substr($this->form['harga_beli'], 4));
        $this->validate();
        // dd($this->form);
        $stocks = Stock::where('user_id', auth()->id())->where('kode', $this->form['kode'])->get();
        if ($stocks->isNotEmpty()) {
            $this->form['harga_beli'] = $frontJumlah;
            $this->error = 'Code already listed please TopUp';
            // $this->addError('form.kode', 'Code already listed please TopUp');
            $this->dispatchBrowserEvent('contentChanged');
            return $this->render();
        }
        $this->form['total'] = $this->form['harga_beli'] * $this->form['lot'] * 100;
        $rekening = Rekening::findOrFail($this->form['rekening_id']);
        if ($this->form['total'] > $rekening->saldo_sekarang) {
            $this->form['harga_beli'] = $frontJumlah;
            $this->addError('form.rekening_id', 'Balance In Pocket Not Enough ');
            return $this->render();
        }

        $rekening->saldo_sekarang -= $this->form['total'];
        $rekening->save();
        if($this->form['financial_plan_id'] != 0){
            $financialplan = FinancialPlan::findOrFail($this->form['financial_plan_id']);
            $financialplan->jumlah += $this->form['total'];
            $financialplan->save();
        }
        Transaction::create([
            'user_id' => auth()->id(),
            'jenisuang_id' => 2,
            'jumlah' => $this->form['total'],
            'rekening_id' => $this->form['rekening_id'],
            'keterangan' => 'Beli Stock ' . $this->form['kode'],
            'category_id' => Category::firstWhere('nama', 'Investment')->id,
        ]);
        Stock::create($this->form + ['user_id' => auth()->id()]);

        session()->flash('success', 'Stock have been saved');
        return redirect(route('stock'));
    }
    public function render()
    {
        return view('livewire.investasi.stock.create-stock');
    }
}
