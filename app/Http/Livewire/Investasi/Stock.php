<?php

namespace App\Http\Livewire\Investasi;

use App\Models\Stock as ModelsStock;
use Livewire\Component;

class Stock extends Component
{
    public $stocks;
    public $stockPrice = [];
    public $unrealized = 0;
    public $gain;
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

            $headers = array();
            $headers[] = 'Accept: application/json';
            $headers[] = 'X-Api-Key: XE6XBRrsIR2TJRK4UVUjhaY739kIFSD24TMxFRcl';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            // dd(json_decode($result)->quoteResponse->result);
            foreach (json_decode($result)->quoteResponse->result as $key => $result) {
                $this->stockPrice[$key] = $result->regularMarketPrice;
            }
            foreach ($this->stocks  as $key => $stock) {
                $this->unrealized += ($this->stockPrice[$key] * $stock->lot * 100) -  $stock->total;
            }
            $this->gain = ($this->unrealized >= 0) ? true : false;
        }
    }
    public function render()
    {

        return view('livewire.investasi.stock');
    }
}
