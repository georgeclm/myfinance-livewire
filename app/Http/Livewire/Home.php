<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\CategoryMasuk;
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
        $this->categories = Category::with('userTransactionsByCategory')->get();
        $this->category_masuks = CategoryMasuk::with('userTransactionsByCategory')->get();
    }
    public function render()
    {
        return view('livewire.home');
    }
}
