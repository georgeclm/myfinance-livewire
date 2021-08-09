<?php

namespace App\Http\Livewire\Setting;

use App\Models\CategoryMasuk;
use Livewire\Component;

class CreateCategoryMasuk extends Component
{
    public $error;
    public $form = [
        'nama' => '',
    ];

    public function rules()
    {
        return [
            'form.nama' => 'required',
        ];
    }

    public function submit()
    {
        $this->validate();
        $category_names = CategoryMasuk::where('user_id', null)->orWhere('user_id', auth()->id())->pluck('nama')->toArray();
        if (in_array(strtolower($this->form['nama']), array_map('strtolower', $category_names))) {
            $this->error = 'Category Already Exists';
            $this->dispatchBrowserEvent('contentChanged');
            return $this->render();
        }
        CategoryMasuk::create([
            'nama' => $this->form['nama'],
            'user_id' => auth()->id()
        ]);
        session()->flash('success', 'New Category have been added');
        return redirect(route('setting'));
    }



    public function render()
    {
        return view('livewire.setting.create-category-masuk');
    }
}
