<?php

namespace App\Livewire\Customer;

use App\Livewire\BaseComponent;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Facades\Password;

#[Title('Forgot Password | Cinecode Customer Portal')]
class ForgotPassword extends BaseComponent
{
    #[Validate('required|email')]
    public $email = '';

    public function sendInstructions()
    {
        $this->validate();

        $status = Password::broker('customers')->sendResetLink(
            ['email' => $this->email]
        );

        $status === Password::RESET_LINK_SENT
            ? $this->success($status)
            : $this->error($status);
    }

    public function render()
    {
        return view('livewire.customer.forgot-password');
    }
}
