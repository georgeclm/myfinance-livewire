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

    public function rules()
    {
        return [
            'form.nama' => 'required',
        ];
    }
    public function submit()
    {
        $this->validate();
        $category_names = Category::where('user_id', null)->orWhere('user_id', auth()->id())->pluck('nama')->toArray();
        if (in_array(strtolower($this->form['nama']), array_map('strtolower', $category_names))) {
            $this->error = 'Category Already Exists';
            $this->dispatchBrowserEvent('contentChanged');
            return $this->render();
        }
        Category::create($this->form + ['user_id' => auth()->id()]);
        $this->form = [
            'nama' => '',
        ];
        session()->flash('success', 'New Category have been added');
        $this->dispatchBrowserEvent('success');

        $this->emit('updateCategory');
    }
    public function render()
    {
        return view('livewire.setting.create-category');
    }
}
