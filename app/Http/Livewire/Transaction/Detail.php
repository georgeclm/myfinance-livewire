<?php

namespace App\Http\Livewire\Transaction;

use App\Models\Category;
use App\Models\CategoryMasuk;
use App\Models\Jenisuang;
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
    public $q = 0;
    public $total;

    public function mount($id)
    {
        $this->jenisuang = Jenisuang::find($id);
        $this->categories = Category::where('user_id', null)->orWhere('user_id', auth()->id())->get();
        $this->category_masuks = CategoryMasuk::where('user_id', null)->orWhere('user_id', auth()->id())->get();
    }

    public function render()
    {
        if ($this->search) {
            $this->transactions = $this->jenisuang->user_transactions($this->q, $this->daterange)->where('category_id', $this->search);
        } else if ($this->search2) {
            $this->transactions = $this->jenisuang->user_transactions($this->q, $this->daterange)->where('category_masuk_id', $this->search2);
        } else {
            $this->transactions = $this->jenisuang->user_transactions($this->q, $this->daterange);
        }
        $this->total = $this->transactions->sum('jumlah');

        return view('livewire.transaction.detail');
    }
}
