<?php

namespace App\Http\Livewire;

use App\Models\Jenisuang;
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
        }
        $transactions = $transactions->latest()->get();
        $income = $transactions->where('jenisuang_id', 1)->where('category_masuk_id', '!=', '10')->sum('jumlah');
        $spending = $transactions->where('jenisuang_id', 2)->where('category_id', '!=', '10')->sum('jumlah');
        $balance = $income - $spending;
        return view('livewire.transaction', compact('income', 'spending', 'balance', 'transactions'));
    }
}
