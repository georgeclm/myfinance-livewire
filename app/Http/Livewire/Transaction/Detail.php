<?php

namespace App\Http\Livewire\Transaction;

use App\Models\Category;
use App\Models\CategoryMasuk;
use App\Models\Jenisuang;
use App\Models\Rekening;
use App\Models\Transaction;
use Livewire\Component;

class Detail extends Component
{

    public $jenisuang;
    public $daterange = null;
    public $transactions;
    public $categories;
    public $category_masuks;
    public $search = 0;
    public $search2 = 0;
    public $total;
    public $jumlah;
    public $jenisuang_id;
    public $transaction;


    public function mount($id)
    {
        $this->jenisuang = Jenisuang::find($id);
        $this->categories = Category::where('user_id', null)->orWhere('user_id', auth()->id())->get();
        $this->category_masuks = CategoryMasuk::where('user_id', null)->orWhere('user_id', auth()->id())->get();
    }

    public function render()
    {
        $this->transactions = Transaction::with(['rekening'])->where('user_id', auth()->id())->where('jenisuang_id', $this->jenisuang->id);

        if ($this->daterange != null) {
            $date_range1 = explode(" / ", $this->daterange);
            $this->transactions = $this->transactions->where('created_at', '>=', $date_range1[0]);
            $this->transactions = $this->transactions->where('created_at', '<=', $date_range1[1]);
        } else {
            $this->transactions = $this->transactions->whereYear('created_at', now()->year)->whereMonth('created_at', now()->month);
        }
        $this->transactions = $this->transactions->latest()->get();
        if ($this->search) {
            $this->transactions = $this->transactions->where('category_id', $this->search);
        } else if ($this->search2) {
            $this->transactions = $this->transactions->where('category_masuk_id', $this->search2);
        }
        if ($this->jenisuang->id == 4) {
            $this->transactions->load('utang');
        }
        if ($this->jenisuang->id == 5) {
            $this->transactions->load('utangteman');
        }
        if ($this->jenisuang->id == 2) {
            $this->transactions->load('category');
        }
        if ($this->jenisuang->id == 1) {
            $this->transactions->load('category_masuk');
        }
        // dd($this->transactions);
        $this->total = $this->transactions->sum('jumlah');
        return view('livewire.transaction.detail');
    }
    public function revert()
    {
        $rekening1 = Rekening::find($this->transaction->rekening_id);

        if ($this->transaction->jenisuang_id == 1) {
            if ($rekening1->saldo_sekarang < $this->transaction->jumlah) {
                return $this->emit('error', 'Pocket doesnt have enough money');
            }
            $rekening1->saldo_sekarang -= $this->transaction->jumlah;
            $rekening1->save();
        } else {
            $rekening1->saldo_sekarang += $this->transaction->jumlah;
            $rekening1->save();
        }
        $this->transaction->delete();
        $this->emit('success', 'Transaction have been reverted');
        $this->emit('hideEdit');
    }
    public function refundModal($primaryId)
    {
        $this->transaction = Transaction::findOrFail($primaryId);
        // dd($transaction);
        $this->jumlah = $this->transaction->jumlah;
        $this->jenisuang_id = $this->transaction->jenisuang_id;
        $this->emit('editModal');
    }
}
