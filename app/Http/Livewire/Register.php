<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class Register extends Component
{

    public $form = [
        'name' => '',
        'email' => '',
        'password' => '',
        'password_confirmation' => '',
    ];



    protected $validationAttributes = [
        'form.name' => 'name',
        'form.email' => 'email',
        'form.password' => 'password'
    ];


    public function rules()
    {
        return [
            'form.email'    => 'required|email|unique:users,email',
            'form.name'     => 'required|min:6',
            'form.password' => ['required',  Password::defaults()->mixedCase()->numbers(), 'confirmed'],
        ];
    }


    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submit()
    {
        $this->validate();

        User::create($this->form);
        Auth::attempt(['email' => $this->form['email'], 'password' => $this->form['password']], true);
        return redirect(route('home'));
    }

    public function render()
    {
        return view('livewire.register');
    }
}
