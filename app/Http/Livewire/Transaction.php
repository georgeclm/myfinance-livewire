<?php

namespace App\Http\Livewire;

use App\Models\Deposito;
use App\Models\Jenisuang;
use App\Models\MutualFund;
use App\Models\P2P;
use App\Models\Stock;
use App\Models\Transaction as ModelsTransaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Transaction extends Component
{

    public $jenisuangs;
    public $daterange = null;

    public function mount()
    {
        $this->jenisuangs = Jenisuang::all();
    }
    public function render()
    {
        $transactions = ModelsTransaction::with(['rekening', 'jenisuang', 'category_masuk', 'category', 'utang', 'utangteman'])->where('user_id', auth()->id());
        if ($this->daterange != null) {
            $date_range1 = explode(" / ", $this->daterange);
            $transactions = $transactions->where('created_at', '>=', $date_range1[0]);
            $transactions = $transactions->where('created_at', '<=', $date_range1[1]);
        } else {
            $transactions = $transactions->whereMonth('created_at', now()->month);
        }
        $transactions = $transactions->latest()->get();
        $income = $transactions->where('jenisuang_id', 1)->where('category_masuk_id', '!=', '10')->sum('jumlah');
        $spending = $transactions->where('jenisuang_id', 2)->where('category_id', '!=', '10')->sum('jumlah');
        $stock = new Stock();
        $totalStockGainOrLoss = $stock->totalGainOrLoss($this->daterange)->sum('gain_or_loss');
        if ($totalStockGainOrLoss > 0) {
            $income += $totalStockGainOrLoss;
        } else {
            $spending -= $totalStockGainOrLoss;
        }
        $p2p = new P2P();
        $totalP2pGain = $p2p->totalGainOrLoss($this->daterange)->sum('gain_or_loss');
        if ($totalP2pGain > 0) {
            $income += $totalP2pGain;
        } else {
            $spending -= $totalP2pGain;
        }
        $mutualFund = new MutualFund();
        $totalMutualFundGain = $mutualFund->totalGainOrLoss($this->daterange)->sum('gain_or_loss');
        if ($totalMutualFundGain > 0) {
            $income -= $totalMutualFundGain;
        } else {
            $spending -= $totalMutualFundGain;
        }
        $deposito = new Deposito();
        $totalDepositoGain = $deposito->totalGainOrLoss($this->daterange)->sum('gain_or_loss');
        if ($totalDepositoGain > 0) {
            $income += $totalDepositoGain;
        } else {
            $spending -= $totalDepositoGain;
        }
        $balance = $income - $spending;
        return view('livewire.transaction', compact('income', 'spending', 'balance', 'transactions'));
    }
}
