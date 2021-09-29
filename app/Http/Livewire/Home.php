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
        auth()->user()->load('all_transactions','uangmasuk');

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
        }else{
            $spending -= $totalStockGainOrLoss;
        }
        $p2p = new P2P();
        $totalP2pGain = $p2p->totalGainOrLoss()->sum('gain_or_loss');
        if ($totalP2pGain > 0) {
            $income += $totalP2pGain;
        }else{
            $spending -= $totalP2pGain;
        }
        $mutualFund = new MutualFund();
        $totalMutualFundGain = $mutualFund->totalGainOrLoss()->sum('gain_or_loss');
        if ($totalMutualFundGain > 0) {
            $income -= $totalMutualFundGain;
        }else{
            $spending -= $totalMutualFundGain;
        }
        $deposito = new Deposito();
        $totalDepositoGain = $deposito->totalGainOrLoss()->sum('gain_or_loss');
        if ($totalDepositoGain > 0) {
            $income += $totalDepositoGain;
        }else{
            $spending -= $totalDepositoGain;
        }
        $balance = $income - $spending;

        return view('livewire.home',compact('income','spending','balance'));
    }
}
