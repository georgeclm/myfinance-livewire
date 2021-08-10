<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

    protected $rules = [
        'form.email'    => 'required|email|unique:users,email',
        'form.name'     => 'required|min:6',
        'form.password' => 'required|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x]).*$/|confirmed',
    ];


    protected $messages = [
        'form.password.regex' => 'Password Must Include Uppercase and number',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submit()
    {
        $this->validate();

        User::create($this->form);
        Auth::attempt(['email' => $this->form['email'], 'password' => bcrypt($this->form['password'])], true);
        return redirect(route('home'));
    }

    public function render()
    {
        return view('livewire.register');
    }
}
