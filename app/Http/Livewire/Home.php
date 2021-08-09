<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\CategoryMasuk;
use Livewire\Component;

class Home extends Component
{

    public $categories;
    public $category_masuks;

    public function mount()
    {
        $this->categories = Category::with('userTransactionsByCategory')->get();
        $this->category_masuks = CategoryMasuk::with('userTransactionsByCategory')->get();
    }
    public function render()
    {
        return view('livewire.home');
    }
}
