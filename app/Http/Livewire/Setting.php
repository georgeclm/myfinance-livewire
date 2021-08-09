<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\CategoryMasuk;
use Livewire\Component;

class Setting extends Component
{
    public $categories;
    public $category_masuks;
    public function mount()
    {
        $this->categories = Category::where('user_id', null)->orWhere('user_id', auth()->id())->get();
        $this->category_masuks = CategoryMasuk::where('user_id', null)->orWhere('user_id', auth()->id())->get();
    }
    public function render()
    {
        return view('livewire.setting');
    }
}
