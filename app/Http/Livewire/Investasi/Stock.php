<?php

namespace App\Http\Livewire\Investasi;

use App\Models\Category;
use App\Models\CategoryMasuk;
use App\Models\FinancialPlan;
use App\Models\Rekening;
use App\Models\Stock as ModelsStock;
use App\Models\Transaction;
use Livewire\Component;

class Stock extends Component
{
    public $stocks;
    public $stockPrice = [];
    public $unrealized = 0;
    public $gain;
    public $stock;
    public $form;
    protected $listeners = ['refreshStock', 'refreshStockRender'];
    public $errorAPI = false;

    public function refreshStockRender()
    {
        $this->render();
    }

    public function refreshStock()
    {
        $this->mount();
    }

    public function topupModal($primaryId)
    {
        $this->stock = ModelsStock::findOrFail($primaryId);
        $this->form = $this->stock->toArray();
        $this->form['lot'] = "";
        $this->form['harga_beli'] = 'Rp  ' . number_format($this->stockPrice[$this->stock->kode] ?? 0, 0, ',', '.');
        $this->emit('editModal');
    }

    public function sellModal($primaryId)
    {
        $this->stock = ModelsStock::findOrFail($primaryId);
        $this->form = $this->stock->toArray();
        $this->form['harga_beli'] = 'Rp  ' . number_format($this->stockPrice[$this->stock->kode] ?? 0, 0, ',', '.');
        $this->emit('deleteModal');
    }

    public function adjustModal($primaryId)
    {
        $this->stock = ModelsStock::findOrFail($primaryId);
        $this->form = $this->stock->toArray();
        $this->form['harga_beli'] = 'Rp  ' . number_format($this->stock->harga_beli, 0, ',', '.');
        $this->emit('adjustModal');
    }

    public function change()
    {
        $this->validate([
            'form.financial_plan_id' => ['required', 'numeric', 'in:' . auth()->user()->financialplans->pluck('id')->implode(',')]
        ]);

        $this->stock->financialplan->jumlah -= $this->stock->total;
        $this->stock->financialplan->save();

        $financialplan = FinancialPlan::findOrFail($this->form['financial_plan_id']);
        $financialplan->jumlah += $this->stock->total;
        $financialplan->save();

        $this->stock->update(['financial_plan_id' => $this->form['financial_plan_id']]);
        $this->emit('hideAdjust');
        $this->emit('success', 'Stock have been changed');
    }

    public function sell()
    {
        $frontJumlah = $this->form['harga_beli'];
        $this->form['harga_beli'] = str_replace('.', '', substr($this->form['harga_beli'], 4));
        $this->validate([
            'form.lot' => ['required', 'numeric'],
            'form.harga_beli' => ['required', 'numeric'],
            'form.rekening_id' => ['required', 'numeric', 'in:' . auth()->user()->rekenings->pluck('id')->implode(',')],
        ]);

        if ($this->form['lot'] > $this->stock->lot) {
            $this->form['harga_beli'] = $frontJumlah;
            return $this->emit('error', 'Total Lot More than the current');
        }

        $total_jual = $this->form['harga_beli'] * $this->form['lot'] * 100;

        $rekening = Rekening::findOrFail($this->form['rekening_id']);
        $rekening->saldo_sekarang += $total_jual;
        $rekening->save();

        $total_beli = $this->stock->harga_beli * $this->form['lot'] * 100;
        if ($this->stock->financial_plan_id != 0) {
            $this->stock->financialplan->jumlah -= $total_beli;
            $this->stock->financialplan->save();
        }
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
            'category_masuk_id' => CategoryMasuk::firstWhere('nama', 'Sell Investment')->id,
        ]);
        $this->emit('hideDelete');
        $this->emit('success', 'Stock have been sold');
    }

    public function topup()
    {
        $frontJumlah = $this->form['harga_beli'];
        $this->form['harga_beli'] = str_replace('.', '', substr($this->form['harga_beli'], 4));
        $this->validate([
            'form.lot' => ['required', 'numeric'],
            'form.harga_beli' => ['required', 'numeric'],
            'form.rekening_id' => ['required', 'numeric', 'in:' . auth()->user()->rekenings->pluck('id')->implode(',')],
        ]);

        $rekening = Rekening::findOrFail($this->form['rekening_id']);
        $total = $this->form['harga_beli'] * $this->form['lot'] * 100;

        if ($total > $rekening->saldo_sekarang) {
            $this->form['harga_beli'] = $frontJumlah;
            return $this->emit('error', 'Balance In Pocket Not Enough');
        }

        $rekening->saldo_sekarang -= $total;
        $rekening->save();
        if ($this->stock->financial_plan_id != 0) {
            $financialplan = FinancialPlan::findOrFail($this->stock->financial_plan_id);
            $financialplan->jumlah += $total;
            $financialplan->save();
        }
        Transaction::create([
            'user_id' => auth()->id(),
            'jenisuang_id' => 2,
            'jumlah' => $total,
            'rekening_id' => $this->form['rekening_id'],
            'keterangan' => 'Buy Stock ' . $this->stock->kode,
            'category_id' => Category::firstWhere('nama', 'Investment')->id,
        ]);

        $total_lot = $this->form['lot'] + $this->stock->lot;
        $avgprice = round((($this->form['harga_beli'] * $this->form['lot']) + ($this->stock->harga_beli * $this->stock->lot)) / $total_lot);
        $this->stock->update([
            'harga_beli' => $avgprice,
            'lot' => $total_lot,
            'keterangan' => $this->form['keterangan'],
            'total' => $total + $this->stock->total
        ]);
        $this->emit('hideEdit');
        $this->emit('success', 'TopUp Successful');
    }

    public function mount()
    {
        $this->stocks = ModelsStock::where('user_id', auth()->id())->where('lot', '!=', 0)->latest()->get();
        $queryString = "https://yfapi.net/v6/finance/quote?symbols=";
        if ($this->stocks->isNotEmpty()) {

            foreach ($this->stocks as $key =>  $stock) {
                if ($key != 0) {
                    $queryString .= "%2C";
                }
                $queryString .=  $stock->kode . ".jk";
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $queryString);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

            $headers = array();
            $headers[] = 'Accept: application/json';
            $headers[] = 'X-Api-Key: ApklkHS2Yc8EBpMPO2DAQ1jrBa0b3QEtkZM9FV20';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            // dd($result);
            curl_close($ch);

            if (!isset(json_decode($result)->quoteResponse)) {
                // abort(500, 'Error:' . curl_error($ch));
                return $this->errorAPI = true;
            }
            // dd(json_decode($result)->quoteResponse->result);
            foreach (json_decode($result)->quoteResponse->result as  $result) {
                $this->stockPrice[str_replace('.JK', '', $result->symbol)] = $result->regularMarketPrice;
            }
        }
    }


    public function render()
    {
        $this->stocks = ModelsStock::where('user_id', auth()->id())->where('lot', '!=', 0)->latest()->get();
        if (!$this->errorAPI) {
            $this->unrealized = 0;
            foreach ($this->stocks  as  $stock) {
                $this->unrealized += ($this->stockPrice[$stock->kode] * $stock->lot * 100) -  $stock->total;
            }
        }
        $this->gain = ($this->unrealized >= 0) ? true : false;
        $this->emit('refresh-chart');
        return view('livewire.investasi.stock');
    }
}
