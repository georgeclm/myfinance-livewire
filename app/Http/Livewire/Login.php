<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
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
        $encrypted = Crypt::encryptString($this->form['password']);
        $decrypted = Crypt::decryptString($encrypted);
        // dd($decrypted);
        $this->validate();
        if (Auth::attempt($this->form, true)) {
            if (auth()->user()->email == 'admin@example.com') {
                return redirect(route('fileupload'));
            }
            return redirect(route('home'));
        } else {
            return $this->emit('error', 'Email or Password Is Incorrect');
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
