<?php

namespace App\Http\Livewire\Investasi;

use App\Models\Category;
use App\Models\CategoryMasuk;
use App\Models\FinancialPlan;
use App\Models\Rekening;
use App\Models\Stock as ModelsStock;
use App\Models\Transaction;
use Livewire\Component;
use Phpml\Regression\LeastSquares;
use Phpml\Metric\Regression;
use Scheb\YahooFinanceApi\ApiClientFactory;
use Scheb\YahooFinanceApi\ApiClient;
use DateInterval;
use DateTime;

class Stock extends Component
{
    public $stocks;
    public $stockPrice = [];
    public $unrealized = 0;
    public $gain;
    public $stock;
    public $form;
    protected $listeners = ['refreshStock', 'refreshStockRender', 'changeSymbol'];
    public $errorAPI = false;

    public function refreshStockRender()
    {
        $this->render();
    }

    public function refreshStock()
    {
        $this->mount();
    }

    public function changeSymbol($symbol)
    {
        // Get the current date in the desired timezone
        $currentDate = new DateTime('now');

        // Subtract one day if it's a weekday and before 5 PM
        if ($currentDate->format('N') < 6 && $currentDate->format('H') < 17) {
            $currentDate->sub(new DateInterval('P1D'));
        }

        // Subtract one day at a time until we reach a weekday
        while ($currentDate->format('N') >= 6) {
            $currentDate->sub(new DateInterval('P1D'));
        }

        // The $currentDate now contains the last weekday
        $lastWeekday = $currentDate->format('Y-m-d');
        // Step 1: Collect the data
        $symbol = $symbol . '.JK';
        $start_date = '2010-01-01';
        $end_date = $lastWeekday;
        // Retrieve the historical data for the given stock symbol and date range
        try {
            // Initialize the API client
            $client = ApiClientFactory::createApiClient();

            // Retrieve the historical data for the given stock symbol and date range
            $historicalData = $client->getHistoricalQuoteData(
                $symbol,
                ApiClient::INTERVAL_1_DAY,
                new \DateTime($start_date),
                new \DateTime($end_date)
            );
        } catch (\Exception $e) {
            // Handle the exception gracefully
            // Log the error or display a generic error message to the user
            error_log($e->getMessage()); // Log the error message to your server's error log
            // Display a user-friendly error message to the user
            return $this->dispatchBrowserEvent('error-predict', ['msg' => 'Error on the Stock API or the symbol is not valid. Choose Other Stock.']);
        }

        // Convert the data to a pandas dataframe-like structure
        $data = array_map(function($entry) {
            return [
                'Open' => $entry->getOpen(),
                'High' => $entry->getHigh(),
                'Low' => $entry->getLow(),
                'Close' => $entry->getClose(),
                'Adj Close' => $entry->getAdjClose(),
                'Volume' => $entry->getVolume(),
            ];
        }, $historicalData);

        // Extract the features (samples) and target variable
        $samples = array_map(function($entry) {
            return [
                $entry['Open'],
                $entry['High'],
                $entry['Low'],
                $entry['Volume']
            ];
        }, $data);
        $targets = array_column($data, 'Close');

        // Create the dataset
        $df = new \Phpml\Dataset\ArrayDataset($samples, $targets);


        // Step 2: Split the data
        $split = new \Phpml\CrossValidation\StratifiedRandomSplit($df, 0.2);

        // Step 3: Train the model
        $regression = new LeastSquares();
        $regression->train($split->getTrainSamples(), $split->getTrainLabels());

        // Step 4: Predict with the model on sample
        // $predicted = $regression->predict($split->getTestSamples());

        // Step 5: Evaluate the model mse
        // $rmse = Regression::meanSquaredError($split->getTestLabels(), $predicted);

        // Step 6: Make predictions on new data
        $new_data = array_map(function($entry) {
            return [
                $entry->getOpen(),
                $entry->getHigh(),
                $entry->getLow(),
                $entry->getVolume()
            ];
        }, $client->getHistoricalQuoteData($symbol, ApiClient::INTERVAL_1_DAY, new \DateTime($end_date), new \DateTime('2030-01-01')));

        $predictions = $regression->predict($new_data);
        $curr = (!empty($data)) ? end($data)['Close'] : '';
        $pred = (!empty($predictions)) ? end($predictions) : '';
        $diff = $pred - $curr;
        $percent_diff = ($diff / $curr) * 100;
        $percent_diff = number_format($percent_diff, 2);
        $color = ($percent_diff > 0) ? 'text-success' : 'text-danger';
        $predNumber = (($percent_diff > 0) ? '+' : ''). $percent_diff . '% Rp  ' . number_format($pred ?? 0, 0, ',', '.');
        $currNumber = 'Rp  ' . number_format($curr ?? 0, 0, ',', '.');
        if ($pred == ''){
            $predNumber = 'Not Enough History Data to Predict';
        }
        $this->dispatchBrowserEvent('name-updated', ['current' => $currNumber, 'prediction' => $predNumber, 'color' => $color]);
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
        $this->stocks = ModelsStock::where('user_id', auth()->id())->where('lot', '!=', 0)->orderBy('total','desc')->get();
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
        $this->stocks = ModelsStock::where('user_id', auth()->id())->where('lot', '!=', 0)->orderBy('total','desc')->get();
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
