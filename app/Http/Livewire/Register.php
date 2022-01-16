<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use ZxcvbnPhp\Zxcvbn;


class Register extends Component
{

    public $form = [
        'name' => '',
        'email' => '',
        'password' => '',
        'password_confirmation' => '',
    ];
    public int $strengthScore = 0;

    public array $passwordStrengthLevels = [
        1 => 'Weak',
        2 => 'Fair',
        3 => 'Good',
        4 => 'Strong'
    ];
    public array $passwordStrengthPercent = [
        1 => 0,
        2 => 33,
        3 => 66,
        4 => 100
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


    public function updated($propertyName, $value)
    {
        if ($propertyName == 'form.password') {
            $this->strengthScore = (new Zxcvbn())->passwordStrength($value)['score'];
        }
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
