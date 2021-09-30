<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\CategoryMasuk;
use App\Models\Deposito;
use App\Models\MutualFund;
use App\Models\P2P;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Home extends Component
{

    public $categories;
    public $category_masuks;
    public $new_user;
    public function mount()
    {
        if (auth()->user()->welcome == 1) {
            $this->new_user = 1;
            auth()->user()->welcome = 0;
            auth()->user()->save();
        } else {
            $this->new_user = 0;
        }
        // dd(auth()->user()->transactions);
        auth()->user()->load('all_transactions', 'uangmasuk');

        $this->categories = Category::with('userTransactionsByCategory')->get();
        $this->category_masuks = CategoryMasuk::with('userTransactionsByCategory')->get();
    }
    public function render()
    {
        $income = Auth::user()->uangmasuk->sum('jumlah');
        $spending = Auth::user()->uangkeluar->sum('jumlah');
        $stock = new Stock();
        $totalStockGainOrLoss = $stock->totalGainOrLoss()->sum('gain_or_loss');
        if ($totalStockGainOrLoss > 0) {
            $income += $totalStockGainOrLoss;
        } else {
            $spending -= $totalStockGainOrLoss;
        }
        $p2p = new P2P();
        $totalP2pGain = $p2p->totalGainOrLoss()->sum('gain_or_loss');
        if ($totalP2pGain > 0) {
            $income += $totalP2pGain;
        } else {
            $spending -= $totalP2pGain;
        }
        $mutualFund = new MutualFund();
        $totalMutualFundGain = $mutualFund->totalGainOrLoss()->sum('gain_or_loss');
        if ($totalMutualFundGain > 0) {
            $income -= $totalMutualFundGain;
        } else {
            $spending -= $totalMutualFundGain;
        }
        $deposito = new Deposito();
        $totalDepositoGain = $deposito->totalGainOrLoss()->sum('gain_or_loss');
        if ($totalDepositoGain > 0) {
            $income += $totalDepositoGain;
        } else {
            $spending -= $totalDepositoGain;
        }
        $balance = $income - $spending;
        $stock = new Stock();
        $p2p = new P2P();
        $mutualFund = new MutualFund();
        $deposito = new Deposito();
        for ($i = 1; $i <= 4; $i++) {
            $prevIncome[$i] = Auth::user()->all_transactions()->whereMonth('created_at', now()->subMonth($i)->month)->where('jenisuang_id', 1)->where('category_masuk_id', '!=', '10')->sum('jumlah');
            $prevSpending[$i] = Auth::user()->all_transactions()->whereMonth('created_at', now()->subMonth($i)->month)->where('jenisuang_id', 2)->where('category_id', '!=', '10')->sum('jumlah');
            $totalStockGainOrLoss = $stock->totalGainOrLossMonth($i)->sum('gain_or_loss');
            if ($totalStockGainOrLoss > 0) {
                $prevIncome[$i] += $totalStockGainOrLoss;
            } else {
                $prevSpending[$i] -= $totalStockGainOrLoss;
            }
            $totalP2pGain = $p2p->totalGainOrLossMonth($i)->sum('gain_or_loss');
            if ($totalP2pGain > 0) {
                $prevIncome[$i] += $totalP2pGain;
            } else {
                $prevSpending[$i] -= $totalP2pGain;
            }
            $totalMutualFundGain = $mutualFund->totalGainOrLossMonth($i)->sum('gain_or_loss');
            if ($totalMutualFundGain > 0) {
                $prevIncome[$i] -= $totalMutualFundGain;
            } else {
                $prevSpending[$i] -= $totalMutualFundGain;
            }
            $totalDepositoGain = $deposito->totalGainOrLossMonth($i)->sum('gain_or_loss');
            if ($totalDepositoGain > 0) {
                $prevIncome[$i] += $totalDepositoGain;
            } else {
                $prevSpending[$i] -= $totalDepositoGain;
            }
        }
        // dd($prevSpending);
        return view('livewire.home', compact('income', 'spending', 'balance', 'prevIncome', 'prevSpending'));
    }
}
