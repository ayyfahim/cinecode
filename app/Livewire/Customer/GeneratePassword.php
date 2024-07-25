<?php

namespace App\Livewire\Customer;

use App\Livewire\BaseComponent;
use App\Models\DistributorEmail;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Genearate Password | Cinecode Customer Portal')]
class GeneratePassword extends BaseComponent
{
    #[Validate('required|exists:distributor_emails,password_generate_token')]
    #[Url]
    public $token = '';

    #[Validate('required|exists:distributor_emails,email')]
    #[Url]
    public $email = '';

    #[Validate('required|confirmed|min:6')]
    public $password = '';

    #[Validate('required')]
    public $password_confirmation = '';

    public function generatePassword()
    {
        $this->validate();

        $distributor = DistributorEmail::where('password_generate_token', $this->token)->where('email', $this->email)->first();

        if (!empty($distributor->password)) {
            $this->error('You have already generated the password.');
        }

        $distributor->update([
            'password' => Hash::make($this->password)
        ]);

        $this->success('Password Generated.');

        return redirect()->route('customer.login');
    }

    public function render()
    {
        return view('livewire.customer.generate-password');
    }
}
