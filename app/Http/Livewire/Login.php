<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;


class Login extends Component
{
    public $form = [
        'email'   => '',
        'password' => '',
    ];


    protected $validationAttributes = [
        'form.email' => 'email',
        'form.password' => 'password'
    ];

    protected $rules = [
        'form.email' => 'required|email',
        'form.password' => 'required',
    ];

    public function submit()
    {
        // $this->addError('email', 'The email field is invalid.');
        $this->validate();
        if (Auth::attempt($this->form, true)) {
            return redirect(route('home'));
        } else {
            session()->flash('error', 'Email or Password Is Incorrect');
            return redirect(route('login'));
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function render()
    {
        return view('livewire.login');
    }
}
