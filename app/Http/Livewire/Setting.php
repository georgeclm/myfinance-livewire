<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\CategoryMasuk;
use Livewire\Component;

class Setting extends Component
{
    public $categories;
    public $category_masuks;
    public $jumlah;
    public function mount()
    {
        $this->jumlah = 'Rp ' . number_format(auth()->user()->previous_p2p, 0, ',', '.');
        $this->categories = Category::where('user_id', null)->orWhere('user_id', auth()->id())->get();
        $this->category_masuks = CategoryMasuk::where('user_id', null)->orWhere('user_id', auth()->id())->get();
    }
    public function submit()
    {
        $this->jumlah = str_replace('.', '', substr($this->jumlah, 4));

        $user = auth()->user();
        $user->previous_p2p = $this->jumlah;
        $user->save();

        session()->flash('success', 'Previous P2P Earning Have Been Saved');
        return redirect(route('setting'));
    }
    public function render()
    {
        return view('livewire.setting');
    }
}
