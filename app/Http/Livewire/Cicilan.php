<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\CategoryMasuk;
use App\Models\Jenisuang;
use Livewire\Component;

class Cicilan extends Component
{

    public $jenisuangs;
    public $categories;
    public $categorymasuks;
    public function mount()
    {
        $this->categories = Category::whereNotIn('nama', ['Adjustment', 'Investment'])->where('user_id', null)->orWhere('user_id', auth()->id())->get();
        $this->categorymasuks = CategoryMasuk::whereNotIn('nama',  ['Adjustment', 'Sell Investment'])->where('user_id', null)->orWhere('user_id', auth()->id())->get();
        $this->jenisuangs = Jenisuang::all();
    }

    public function render()
    {
        return view('livewire.cicilan');
    }
}
