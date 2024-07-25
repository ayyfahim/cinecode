<?php

namespace App\Livewire\Customer;

use App\Livewire\BaseComponent;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;

#[Title('Login | Cinecode Customer Portal')]
class Login extends BaseComponent
{
    #[Validate('required|email')]
    public $email = '';

    #[Validate('required')]
    public $password = '';


    public function login()
    {
        $validated = $this->validate();

        if (auth('customer')->attempt($validated)) {
            return redirect()->intended(route('customer.shop'));
        }

        $this->error('Please enter correct email or password.');

        // dd(session()->all());
    }

    public function dummy_alert()
    {
        $this->success('User created!');
    }

    public function render()
    {

        return view('livewire.customer.login');
    }
}
