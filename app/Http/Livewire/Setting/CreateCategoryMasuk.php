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
        CategoryMasuk::create($this->form + ['user_id' => auth()->id()]);
        $this->form = [
            'nama' => '',
        ];
        session()->flash('success', 'New Category have been added');
        $this->dispatchBrowserEvent('success');

        $this->emit('updateCategoryMasuk');
    }



    public function render()
    {
        return view('livewire.setting.create-category-masuk');
    }
}
