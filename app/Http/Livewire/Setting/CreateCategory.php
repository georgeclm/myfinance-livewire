<?php

namespace App\Http\Livewire\Setting;

use App\Models\Category;
use Livewire\Component;

class CreateCategory extends Component
{
    public $error;
    public $form = [
        'nama' => '',
    ];

    protected $validationAttributes = [
        'form.nama' => 'Spending Category',
    ];

    public function rules()
    {
        return [
            'form.nama' => 'required|unique:categories,nama',
        ];
    }
    public function submit()
    {
        $this->validate();
        Category::create($this->form + ['user_id' => auth()->id()]);
        $this->form = [
            'nama' => '',
        ];
        $this->emit('success', 'New Category have been added');
        $this->emit('updateCategory');
        $this->emit('hidemodalSaving');
    }
    public function render()
    {
        return view('livewire.setting.create-category');
    }
}
