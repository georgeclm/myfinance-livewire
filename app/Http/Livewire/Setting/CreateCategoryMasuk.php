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

    protected $validationAttributes = [
        'form.nama' => 'Income Category',
    ];

    public function rules()
    {
        return [
            'form.nama' => 'required|unique:category_masuks,nama',
        ];
    }

    public function submit()
    {
        $this->validate();
        CategoryMasuk::create($this->form + ['user_id' => auth()->id()]);
        $this->form = [
            'nama' => '',
        ];
        $this->emit('success', 'New Category have been added');
        $this->emit('hidemodalFund');
        $this->emit('updateCategoryMasuk');
    }



    public function render()
    {
        return view('livewire.setting.create-category-masuk');
    }
}
