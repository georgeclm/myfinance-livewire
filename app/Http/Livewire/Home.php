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
        $incomeDiff = $income;
        $spendingDiff = $spending;
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
            $income += $totalMutualFundGain;
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
        $incomeDiff = $income - $incomeDiff;
        $spendingDiff = $spending - $spendingDiff;

        $incomeDiffPercent = (auth()->user()->uangmasuk->sum('jumlah') + $incomeDiff != 0) ?  round($incomeDiff / (auth()->user()->uangmasuk->sum('jumlah') + $incomeDiff) * 100) : 0;
        $spendingDiffPercent = (auth()->user()->uangkeluar->sum('jumlah') + $spendingDiff != 0) ? round($spendingDiff / (auth()->user()->uangkeluar->sum('jumlah') + $spendingDiff) * 100) : 0;
        for ($i = 1; $i <= 4; $i++) {
            $prevIncome[$i] = cache()->remember('prevIncome' . $i, 60 * 60 * 24 * 30, function () use ($i) {
                return Auth::user()->all_transactions()->whereMonth('created_at', now()->subMonth($i)->month)->where('jenisuang_id', 1)->where('category_masuk_id', '!=', '10')->sum('jumlah');
            });
            $prevSpending[$i] = cache()->remember('prevSpending' . $i, 60 * 60 * 24 * 30, function () use ($i) {
                return Auth::user()->all_transactions()->whereMonth('created_at', now()->subMonth($i)->month)->where('jenisuang_id', 2)->where('category_id', '!=', '10')->sum('jumlah');
            });
            $totalStockGainOrLoss = cache()->remember('totalStockGainOrLoss' . $i, 60 * 60 * 24 * 30, function () use ($i,$stock) {
                return $stock->totalGainOrLossMonth($i)->sum('gain_or_loss');
            });
            if ($totalStockGainOrLoss > 0) {
                $prevIncome[$i] += $totalStockGainOrLoss;
            } else {
                $prevSpending[$i] -= $totalStockGainOrLoss;
            }
            $totalP2pGain = cache()->remember('totalP2pGain' . $i, 60 * 60 * 24 * 30, function () use ($i,$p2p) {
                return $p2p->totalGainOrLossMonth($i)->sum('gain_or_loss');
            });
            if ($totalP2pGain > 0) {
                $prevIncome[$i] += $totalP2pGain;
            } else {
                $prevSpending[$i] -= $totalP2pGain;
            }
            $totalMutualFundGain = cache()->remember('totalMutualFundGain' . $i, 60 * 60 * 24 * 30, function () use ($i,$mutualFund) {
                return $mutualFund->totalGainOrLossMonth($i)->sum('gain_or_loss');
            });
            if ($totalMutualFundGain > 0) {
                $prevIncome[$i] += $totalMutualFundGain;
            } else {
                $prevSpending[$i] -= $totalMutualFundGain;
            }
            $totalDepositoGain = cache()->remember('totalDepositoGain' . $i, 60 * 60 * 24 * 30, function () use ($i,$deposito) {
                return $deposito->totalGainOrLossMonth($i)->sum('gain_or_loss');
            });
            if ($totalDepositoGain > 0) {
                $prevIncome[$i] += $totalDepositoGain;
            } else {
                $prevSpending[$i] -= $totalDepositoGain;
            }
        }
        // dd($incomeDiff);
        $this->dispatchBrowserEvent('refresh-chart');

        return view('livewire.home', compact('income', 'spending', 'balance', 'prevIncome', 'prevSpending', 'incomeDiff', 'spendingDiff', 'spendingDiffPercent', 'incomeDiffPercent'));
    }
}
