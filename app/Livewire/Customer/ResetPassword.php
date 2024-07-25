<?php

namespace App\Livewire\Customer;

use App\Livewire\BaseComponent;
use App\Models\DistributorEmail;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Str;


#[Title('Reset Password | Cinecode Customer Portal')]
class ResetPassword extends BaseComponent
{
    #[Validate('required|email|exists:distributor_emails,email')]
    #[Url]
    public $email = '';

    #[Validate('required')]
    #[Url]
    public $token = '';

    #[Validate('required|confirmed|min:6')]
    public $password = '';

    #[Validate('required')]
    public $password_confirmation = '';

    public function resetPassword()
    {
        $this->validate();

        $status = Password::broker('customers')->reset(
            ['email' => $this->email, 'password' => $this->password, 'password_confirmation' => $this->password_confirmation, 'token' => $this->token],
            function (DistributorEmail $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ]);
                // ->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        $status === Password::PASSWORD_RESET
            ? $this->success($status)
            : $this->error($status);

        if ($status) {
            $this->reset('password', 'password_confirmation');
        }

        return redirect()->route('customer.login');
    }

    public function render()
    {
        return view('livewire.customer.reset-password');
    }
}
